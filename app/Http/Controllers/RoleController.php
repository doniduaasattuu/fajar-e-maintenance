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

        if ($nik == Auth::user()->nik) {
            return back()->with('modal', new Modal('[403] Forbidden', 'You cannot unassign yourself, this action causes an error.'));
        }

        if ($nik == '55000154') {
            return back()->with('modal', new Modal('[403] Forbidden', 'You cannot delete the creator.'));
        }

        if (!is_null($user)) {
            $user->roles()->detach('admin');
            Log::info('user assigned as admin success', ['user' => $user->fullname, 'admin' => Auth::user()->fullname]);
            return back()->with('modal', new Modal('[200] Success', 'User removed from admin.'));
        } else {
            return back()->with('modal', new Modal('[404] Not found', 'User not found.'));
        }
    }

    public function roleAssignSuperAdmin(string $nik): RedirectResponse
    {
        $user = User::query()->find($nik);

        if ($user->isSuperAdmin()) {
            return back()->with('modal', new Modal('[204] Success', 'The user is already an super admin.'));
        }

        if (!is_null($user)) {
            $user->roles()->attach('superadmin');
            Log::info('user assigned as superadmin success', ['user' => $user->fullname, 'superadmin' => Auth::user()->fullname]);
            return back()->with('modal', new Modal('[200] Success', 'The user assigned as super admin.'));
        } else {
            return back()->with('modal', new Modal('[404] Not found', 'User not found.'));
        }
    }

    public function roleDeleteSuperAdmin(string $nik)
    {
        $user = User::query()->find($nik);

        if (!$user->isSuperAdmin()) {
            return back()->with('modal', new Modal('[204] Success', 'The user is no longer an super admin.'));
        }

        if ($nik == '55000154') {
            return back()->with('modal', new Modal('[403] Forbidden', 'You cannot delete the creator.'));
        }

        if ($nik == Auth::user()->nik) {
            return back()->with('modal', new Modal('[403] Forbidden', 'You cannot unassign yourself, this action causes an error.'));
        }

        if (!is_null($user)) {
            $user->roles()->detach('superadmin');
            Log::info('user assigned as superadmin success', ['user' => $user->fullname, 'superadmin' => Auth::user()->fullname]);
            return back()->with('modal', new Modal('[200] Success', 'User removed from super admin.'));
        } else {
            return back()->with('modal', new Modal('[404] Not found', 'User not found.'));
        }
    }
}
