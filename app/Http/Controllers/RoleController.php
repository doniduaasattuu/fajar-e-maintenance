<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{

    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function roleDeleteDbAdmin(string $nik)
    {
        if ($nik == '55000154') {
            return redirect()->back()->with('message', ['header' => '[405] Method Not Allowed!', 'message' => 'You cannot delete the creator!.']);
        }

        try {
            $this->roleService->deleteDbAdmin($nik);
        } catch (Exception $error) {
            return redirect()->back()->with('message', ['header' => '[500] Internal Server Error!', 'message' => $error->getMessage()]);
        }
        return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => "User deleted from database administrator."]);
    }

    public function roleAssignDbAdmin(string $nik)
    {
        try {
            $this->roleService->assignDbAdmin($nik);
        } catch (Exception $error) {
            return redirect()->back()->with('message', ['header' => '[500] Internal Server Error!', 'message' => $error->getMessage()]);
        }
        return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => "User assigned as database administrator."]);
    }

    public function roleDeleteAdmin(string $nik)
    {
        if ($nik == '55000154') {
            return redirect()->back()->with('message', ['header' => '[405] Method Not Allowed!', 'message' => 'You cannot delete the creator!.']);
        }

        try {
            $this->roleService->deleteAdmin($nik);
        } catch (Exception $error) {
            return redirect()->back()->with('message', ['header' => '[500] Internal Server Error!', 'message' => $error->getMessage()]);
        }
        return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => "User deleted from administrator."]);
    }

    public function roleAssignAdmin(string $nik)
    {
        try {
            $this->roleService->assignAdmin($nik);
        } catch (Exception $error) {
            return redirect()->back()->with('message', ['header' => '[500] Internal Server Error!', 'message' => $error->getMessage()]);
        }
        return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => "User assigned as administrator."]);
    }
}
