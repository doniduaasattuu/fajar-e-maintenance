<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use App\Rules\UserExists;
use App\Rules\ValidRegistrationCode;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private UserService $userService;
    private RoleService $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function registration()
    {
        return response()->view('user.registration', [
            'title' => 'Registration',
            'userService' => $this->userService,
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
            'registration_code' => ['required', new ValidRegistrationCode()],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->safe()->except(['registration_code']);

            try {
                $this->userService->register($validated);
            } catch (Exception $error) {
                return redirect()->back()->with('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
            }

            return redirect('login')->with('alert', ['message' => 'Your account successfully registered.', 'variant' => 'alert-success']);
        } else {
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

                return redirect()->route('home');
            } else {

                $validator->errors()->add('nik', 'The nik or password is wrong.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function logout(Request $request)
    {
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
                return redirect()->back()->with('alert', ['message' => $error->getMessage(), 'variant' => 'alert-danger']);
            }

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
            return redirect()->back()->with('message', ['header' => '[403] You are not allowed!', 'message' => 'You cannot delete your self, this action causes an error.']);
        }

        if ($nik == '55000154') {
            return redirect()->back()->with('message', ['header' => '[403] You are not allowed!', 'message' => 'You cannot delete the creator!.']);
        }

        if (!is_null($user)) {

            $roles = Role::query()->where('nik', '=', $nik)->get();

            foreach ($roles as $role) {
                $role->delete();
            }

            $user->delete();
            return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => 'User successfully deleted!.']);
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found!', 'message' => 'User not found!.']);
        }
    }

    public function userReset(string $nik)
    {
        $user = User::query()->find($nik);

        if ($nik == '55000154') {
            return redirect()->back()->with('message', ['header' => '[403] You are not allowed!', 'message' => 'You cannot reset the creator!.']);
        }

        if (!is_null($user)) {

            $user->password = '@Fajarpaper123';
            $user->update();

            return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => "User password reset successfully."]);
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found!', 'message' => "User not found!."]);
        }
    }
}
