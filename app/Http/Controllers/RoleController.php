<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{

    private UserService $userService;
    private RoleService $roleService;

    public function __construct(RoleService $roleService, UserService $userService)
    {
        $this->roleService = $roleService;
        $this->userService = $userService;
    }

    public function roleDeleteDbAdmin(string $nik)
    {
        if ($nik == env('CREATOR', '55000154')) {
            Log::alert('user tries to unassign the creator from db_admin', ['admin' => session('user')]);
            return redirect()->back()->with('message', ['header' => '[405] Method Not Allowed!', 'message' => 'You cannot delete the creator!.']);
        }

        try {
            $this->roleService->deleteDbAdmin($nik);
        } catch (Exception $error) {
            Log::error('user tries to unassign db_admin', ['user' => $this->userService->user($nik)->fullname, 'admin' => session('user'), 'message' => $error->getMessage()]);
            return redirect()->back()->with('message', ['header' => '[500] Internal Server Error!', 'message' => $error->getMessage()]);
        }
        Log::info("user removed $nik from db_admin", ['user' => $this->userService->user($nik)->fullname, 'admin' => session('user')]);
        return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => "User removed from database administrator."]);
    }

    public function roleAssignDbAdmin(string $nik)
    {
        try {
            $this->roleService->assignDbAdmin($nik);
        } catch (Exception $error) {
            Log::error('user assigned as db_admin', ['user' => $this->userService->user($nik)->fullname, 'admin' => session('user'), 'message' => $error->getMessage()]);
            return redirect()->back()->with('message', ['header' => '[500] Internal Server Error!', 'message' => $error->getMessage()]);
        }
        Log::info('user assigned as db_admin success', ['user' => $this->userService->user($nik)->fullname, 'admin' => session('user')]);
        return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => "User assigned as database administrator."]);
    }

    public function roleDeleteAdmin(string $nik)
    {
        if ($nik == session('nik')) {
            Log::alert('user tries to unnasign himself from admin', ['admin' => session('user')]);
            return redirect()->back()->with('message', ['header' => '[405] Method Not Allowed!', 'message' => 'You cannot unassign yourself, this action causes an error.']);
        }

        if ($nik == env('CREATOR', '55000154')) {
            Log::alert('user tries to unnasign the creator from admin', ['admin' => session('user')]);
            return redirect()->back()->with('message', ['header' => '[405] Method Not Allowed!', 'message' => 'You cannot delete the creator!.']);
        }

        try {
            $this->roleService->deleteAdmin($nik);
        } catch (Exception $error) {
            Log::error("user tries to unnasign $nik from admin", ['admin' => session('user')]);
            return redirect()->back()->with('message', ['header' => '[500] Internal Server Error!', 'message' => $error->getMessage()]);
        }
        Log::info("user removed $nik from admin", ['user' => $this->userService->user($nik)->fullname, 'admin' => session('user')]);
        return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => "User removed from administrator."]);
    }

    public function roleAssignAdmin(string $nik)
    {
        try {
            $this->roleService->assignAdmin($nik);
        } catch (Exception $error) {
            Log::error('user tries to assign admin', ['user' => $this->userService->user($nik)->fullname, 'admin' => session('user'), 'message' => $error->getMessage()]);
            return redirect()->back()->with('message', ['header' => '[500] Internal Server Error!', 'message' => $error->getMessage()]);
        }
        Log::info('user assigned as admin success', ['user' => $this->userService->user($nik)->fullname, 'admin' => session('user')]);
        return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => "User assigned as administrator."]);
    }
}
