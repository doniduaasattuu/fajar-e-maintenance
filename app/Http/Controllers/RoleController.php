<?php

namespace App\Http\Controllers;

use App\Data\Modal;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{

    public function roleAssignAdmin(string $nik): RedirectResponse
    {
        $user = User::query()->find($nik);

        if ($user->isAdmin()) {
            return back()->with('modal', new Modal('[204] Success', 'The user is already an admin.'));
        }

        if (!is_null($user)) {
            $user->roles()->attach('admin');
            Log::info('user assigned as admin success', ['user' => $user->fullname, 'admin' => Auth::user()->fullname]);
            return back()->with('modal', new Modal('[200] Success', 'The user assigned as admin.'));
        } else {
            return back()->with('modal', new Modal('[404] Not found', 'User not found.'));
        }
    }

    public function roleDeleteAdmin(string $nik)
    {
        $user = User::query()->find($nik);

        if (!$user->isAdmin()) {
            return back()->with('modal', new Modal('[204] Success', 'The user is no longer an admin.'));
        }

        if (!is_null($user)) {
            $user->roles()->detach('admin');
            Log::info('user assigned as admin success', ['user' => $user->fullname, 'admin' => Auth::user()->fullname]);
            return back()->with('modal', new Modal('[200] Success', 'User removed from admin.'));
        } else {
            return back()->with('modal', new Modal('[404] Not found', 'User not found.'));
        }
    }
}
