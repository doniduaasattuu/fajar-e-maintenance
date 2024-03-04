<?php

namespace App\Http\Controllers;

use App\Data\Alert;
use App\Data\Modal;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use App\Rules\UserExists;
use App\Rules\ValidRegistrationCode;
use App\Services\RoleService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
    }

    public function login()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function registration()
    {
        return view('auth.registration', [
            'title' => 'Registration'
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['required', 'digits:8', 'numeric', new UserExists($this->userService)],
            'password' => ['required', 'max:25', Password::min('8')->letters()->mixedCase()->numbers()->symbols()],
            'fullname' => ['required', 'regex:/^[a-zA-Z\s]+$/u', 'min:6', 'max:50'],
            'department' => ['required', Rule::in(User::$departments)],
            'phone_number' => ['required', 'numeric', 'digits_between:10,13'],
            'registration_code' => ['required', new ValidRegistrationCode()],
        ]);

        User::insert([
            'nik' => $request->nik,
            'password' => bcrypt($request->password),
            'fullname' => $request->fullname,
            'department' => $request->department,
            'phone_number' => $request->phone_number,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        Log::info('user register success', ['nik' => $validated['nik'], 'user' => $validated['fullname']]);
        return redirect('login')->with('alert', new Alert('Your account successfully registered.', 'alert-success'));
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'nik' => ['required', 'numeric'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended();
        }

        return back()->withErrors([
            'nik' => 'The nik or password is wrong.',
        ])->onlyInput('nik');
    }

    public function logout(Request $request)
    {
        Log::info('user logout', ['nik' => Auth::user()->nik, 'user' => Auth::user()->fullname]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function profile()
    {
        return view('auth.profile', [
            'title' => 'My profile',
            'userService' => $this->userService,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->merge(['current_nik' => Auth::user()->nik]);

        $validated = $request->validate([
            'nik' => ['required', 'digits:8', 'numeric', 'same:current_nik', Rule::in($this->userService->registeredNiks())],
            'fullname' => ['required', 'regex:/^[a-zA-Z\s]+$/u', 'min:6', 'max:25'],
            'department' => ['required', Rule::in(User::$departments)],
            'phone_number' => ['required', 'numeric', 'digits_between:10,13'],
            'new_password' => ['required',  Password::min('8')->letters()->mixedCase()->numbers()->symbols()],
            'new_password_confirmation' => ['required', 'same:new_password', Password::min('8')->letters()->mixedCase()->numbers()->symbols()],
        ]);

        $user = User::find($validated['nik']);
        $user->nik = $validated['nik'];
        $user->password = bcrypt($validated['new_password']);
        $user->fullname = $validated['fullname'];
        $user->department = $validated['department'];
        $user->phone_number = $validated['phone_number'];
        $user->update();

        Log::info('user updated', ['nik' => Auth::user()->nik, 'user' => Auth::user()->fullname]);
        return back()->with('alert', new Alert('Your profile successfully updated.', 'alert-success'));
    }

    public function userReset(string $nik)
    {
        $user = User::query()->find($nik);

        if ($nik == '55000154') {
            Log::alert('user tries to reset creator password', ['admin' => Auth::user()->fullname]);
            return back()->with('modal', new Modal('[403] Forbidden', 'You cannot reset the creator!.'));
        }

        if (!is_null($user) && Auth::user()->isSuperAdmin()) {
            $user->password = bcrypt(env('DEFAULT_PASSWORD', '@Fajarpaper123'));
            $user->updated_at = Carbon::now()->toDateTimeString();
            $user->update();

            Log::info('user password reset success', ['user' => $user->fullname, 'admin' => Auth::user()->fullname]);
            return back()->with('modal', new Modal('[200] Success', 'User password reset successfully.'));
        } else {
            return back()->with('modal', new Modal('[404] Not found', 'User not found.'));
        }
    }

    public function users(Request $request)
    {
        $search = $request->query('search');
        $dept = $request->query('dept');

        function ownQuery($search)
        {
            if (!is_null($search) && is_numeric($search)) {
                return User::query()
                    ->when($search, function ($query, $search) {
                        $query
                            ->where('nik', 'like', "%{$search}%");
                    });
            } else if (!is_null($search) && !is_numeric($search)) {
                return User::query()
                    ->when($search, function ($query, $search) {
                        $query
                            ->where('fullname', 'like', "%{$search}%");
                    });
            } else {
                return User::query();
            }
        }

        $paginate = ownQuery($search)
            ->when($dept, function ($query, $dept) {
                $query
                    ->where('department', '=', $dept);
            })
            ->paginate()
            ->withQueryString();

        return view('auth.users', [
            'title' => 'User management',
            'userService' => $this->userService,
            'paginate' => $paginate,
        ]);

        // if (is_numeric($search)) {
        //     $paginate = User::query()
        //         ->when($dept, function ($query, $dept) {
        //             $query
        //                 ->where('department', '=', $dept);
        //         })
        //         ->when($search, function ($query, $search) {
        //             $query
        //                 ->where('nik', 'like', "%{$search}%");
        //         })
        //         ->paginate(5)
        //         ->withQueryString();
        // } else {
        //     $paginate = User::query()
        //         ->when($dept, function ($query, $dept) {
        //             $query
        //                 ->where('department', '=', $dept);
        //         })
        //         ->when($search, function ($query, $search) {
        //             $query
        //                 ->where('fullname', 'like', "%{$search}%");
        //         })
        //         ->paginate(5)
        //         ->withQueryString();
        // }
    }

    public function userDelete(string $nik)
    {
        $user = User::query()->find($nik);

        if ($nik == Auth::user()->nik) {
            Log::alert('user tries to delete himself', ['superadmin' => Auth::user()->fullname]);
            return back()->with('modal', new Modal('[403] Forbidden', 'You cannot delete your self, this action causes an error.'));
        }

        if ($nik == '55000154') {
            Log::alert('user tries to delete the creator', ['superadmin' => Auth::user()->fullname]);
            return back()->with('modal', new Modal('[403] Forbidden', 'You cannot delete the creator.'));
        }

        if (!is_null($user)) {

            $roles = Role::pluck('role');
            foreach ($roles as $role) {
                $user->roles()->detach($role);
            }
            $user->delete();

            Log::info('user deleted success', ['deleted' => $user->fullname, 'superadmin' => Auth::user()->fullname]);
            return back()->with('modal', new Modal('[200] Success', 'User successfully deleted.'));
        } else {
            return back()->with('modal', new Modal('[404] Not found', 'User not found.'));
        }
    }

    // public function userReset(string $nik)
    // {
    //     $user = User::query()->find($nik);

    //     if ($nik == '55000154') {
    //         Log::alert('user tries to reset creator password', ['admin' => Auth::user()->fullname]);
    //         return back()->with('message', ['header' => '[403] You are not allowed!', 'message' => 'You cannot reset the creator!.']);
    //     }

    //     if (!is_null($user)) {

    //         $user->password = env('DEFAULT_PASSWORD', '@Fajarpaper123');
    //         $user->updated_at = Carbon::now()->toDateTimeString();
    //         $user->update();

    //         Log::info('user password reset success', ['user' => $user->fullname, 'admin' => Auth::user()->fullname]);
    //         return back()->with('message', ['header' => '[200] Success!', 'message' => "User password reset successfully."]);
    //     } else {
    //         return back()->with('message', ['header' => '[404] Not found!', 'message' => "User not found!."]);
    //     }
    // }


    // ============================

    public function userRegistration()
    {
        return response()->view('user.user-registration', [
            'title' => 'User registration',
            'userService' => $this->userService,
            'action' => '/user-registration',
        ]);
    }
}
