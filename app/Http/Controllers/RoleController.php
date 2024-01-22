<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function roleDeleteDbAdmin(string $nik)
    {
        $DbAdminRoles = Role::query()->where('role', '=', 'db_admin')->where('nik', '=', $nik)->get();

        foreach ($DbAdminRoles as $role) {
            try {
                $role->delete();
            } catch (Exception $error) {
                return redirect()->back()->with('message', ['header' => '[404] Not found!', 'message' => $error->getMessage()]);
            }
        }
        return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => "User deleted successfully."]);
    }

    public function roleDeleteAdmin(string $nik)
    {
        $AdminRoles = Role::query()->where('role', '=', 'admin')->where('nik', '=', $nik)->get();

        foreach ($AdminRoles as $role) {
            try {
                $role->delete();
            } catch (Exception $error) {
                return redirect()->back()->with('message', ['header' => '[404] Not found!', 'message' => $error->getMessage()]);
            }
        }

        return redirect()->back()->with('message', ['header' => '[200] Success!', 'message' => "User deleted successfully."]);
    }
}
