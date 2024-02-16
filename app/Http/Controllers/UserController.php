<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use App\Rules\UserExists;
use App\Rules\ValidRegistrationCode;
use App\Services\RoleService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
    }

    public function registration()
    {
        return response()->view('user.registration', [
            'title' => 'Registration',
            'userService' => $this->userService,
            'action' => '/registration',
        ]);
    }

    public function register(Request $request)
    {
        $rules = [
            'nik' => ['required', 'digits:8', 'numeric', new UserExists($this->userService)],
            'password' => ['required', 'max:25', Password::min('8')->letters()->mixedCase()->numbers()->symbols()],
            'fullname' => ['required', 'regex:/^[a-zA-Z\s]+$/u', 'min:6', 'max:50'],
            'department' => ['required', Rule::in($this->userService->departments())],
            'phone_number' => ['required', 'numeric', 'digits_between:10,13'],
            'registration_code' => ['required', new ValidRegistrationCode($this->userService)],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->safe()->except(['registration_code']);

            try {
                $this->userService->register($validated);
            } catch (Exception $error) {
                Log::error('user registration', ['user' => $validated['fullname'], 'message' => $error->getMessage()]);
                return redirect()->back()->with('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
            }

            if (!is_null(session('nik'))) {
                Log::info('user ' . $validated['nik'] . ' registered by admin', ['user' => $validated['fullname'], 'admin' => session('user')]);
                return redirect()->back()->with('alert', ['message' => 'User account successfully registered.', 'variant' => 'alert-success']);
            } else {
                Log::info('user register success', ['nik' => $validated['nik'], 'user' => $validated['fullname']]);
                return redirect('login')->with('alert', ['message' => 'Your account successfully registered.', 'variant' => 'alert-success']);
            }
        } else {
            Log::info('user try registration', ['nik' => $request->input('nik'), 'ip' => $request->ip()]);
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function login()
    {
        return response()->view('user.login', [
            'title' => 'Login'
        ]);
    }

    public function doLogin(Request $request)
    {
        $rules = [
            'nik' => ['required', 'numeric'],
            'password' => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();

            if ($this->userService->login($validated)) {

                $user = User::query()->find($validated['nik']);
                session(["nik" => $user->nik]);
                session(["user" => $user->fullname]);
                Log::info('user login', ['nik' => $user->nik, 'user' => $user->fullname]);

                return redirect()->route('home');
            } else {

                Log::info('user login failed', ['nik' => $validated['nik'], 'password' => $validated['password']]);
                $validator->errors()->add('nik', 'The nik or password is wrong.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function logout(Request $request)
    {
        Log::info('user logout', ['nik' => session('nik'), 'user' => session('user')]);
        $request->session()->flush();
        return redirect()->route('login');
    }

    public function profile()
    {
        return response()->view('user.profile', [
            'title' => 'My profile',
            'userService' => $this->userService,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'nik' => ['required', 'digits:8', 'numeric', Rule::in(session('nik')), Rule::in($this->userService->registeredNiks())],
            'fullname' => ['required', 'regex:/^[a-zA-Z\s]+$/u', 'min:6', 'max:25'],
            'department' => ['required', Rule::in($this->userService->departments())],
            'phone_number' => ['required', 'numeric', 'digits_between:10,13'],
            'new_password' => ['required',  Password::min('8')->letters()->mixedCase()->numbers()->symbols()],
            'new_password_confirmation' => ['required', 'same:new_password', Password::min('8')->letters()->mixedCase()->numbers()->symbols()],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $confirmed_password = $validator->validated()['new_password_confirmation'];
            $validated = $validator->safe()->except(['new_password', 'new_password_confirmation']);
            $validated['password'] = $confirmed_password;

            try {
                $this->userService->updateProfile($validated);
            } catch (Exception $error) {
                Log::error('user update', ['user' => $validated['fullname'], 'message' => $error->getMessage()]);
                return redirect()->back()->with('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
            }

            Log::info('user updated', ['nik' => session('nik'), 'user' => session('user')]);
            return redirect()->back()->with('alert', ['message' => 'Your profile successfully updated.', 'variant' => 'alert-success']);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function users()
    {
        $users = User::query()->get();

        return response()->view('user.users', [
            'title' => 'User management',
            'userService' => $this->userService,
            'users' => $users,
        ]);
    }

    public function userDelete(string $nik)
    {
        $user = User::query()->find($nik);

        if ($nik == session('nik')) {
            Log::alert('user tries to delete himself', ['admin' => session('user')]);
            return redirect()->back()->with('message', ['header' => '[403] You are not allowed!', 'message' => 'You cannot delete your self, this action causes an error.']);
        }

        if ($nik == '55000154') {
            Log::alert('user tries to delete the creator', ['admin' => session('user')]);
            return redirect()->back()->with('message', ['header' => '[403] You are not allowed!', 'message' => 'You cannot delete the creator!.']);
        }

        if (!is_null($user)) {

            try {
                // DELETE ROLES
                $roles = Role::query()->where('nik', '=', $nik)->get();
                foreach ($roles as $role) {
                    $role->delete();
                }
                $user->delete();
            } catch (Exception $error) {
                Log::error('user deleted', ['user' => $user->fullname, 'admin' => session('user'), 'message' => $error->getMessage()]);
                return redirect()->back()->with('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
            }

            Log::info('user deleted success', ['deleted' => $user->fullname, 'admin' => session('user')]);
            return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => 'User successfully deleted!.']);
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found!', 'message' => 'User not found!.']);
        }
    }

    public function userReset(string $nik)
    {
        $user = User::query()->find($nik);

        if ($nik == '55000154') {
            Log::alert('user tries to reset creator password', ['admin' => session('user')]);
            return redirect()->back()->with('message', ['header' => '[403] You are not allowed!', 'message' => 'You cannot reset the creator!.']);
        }

        if (!is_null($user)) {

            $user->password = env('DEFAULT_PASSWORD', '@Fajarpaper123');
            $user->updated_at = Carbon::now()->toDateTimeString();
            $user->update();

            Log::info('user password reset success', ['user' => $user->fullname, 'admin' => session('user')]);
            return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => "User password reset successfully."]);
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found!', 'message' => "User not found!."]);
        }
    }

    public function userRegistration()
    {
        return response()->view('user.user-registration', [
            'title' => 'User registration',
            'userService' => $this->userService,
            'action' => '/user-registration',
        ]);
    }
}
