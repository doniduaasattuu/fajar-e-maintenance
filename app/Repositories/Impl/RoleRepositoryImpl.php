<?php

namespace App\Repositories\Impl;

use App\Models\Role;
use App\Repositories\RoleRepository;

class RoleRepositoryImpl implements RoleRepository
{
    public function delete(string $nik, string $role): bool
    {
        $roles = Role::query()->where('role', '=', $role)->where('nik', '=', $nik)->get();

        foreach ($roles as $role) {
            $role->delete();
        }

        return true;
    }

    public function assign(string $nik, string $role): bool
    {
        $this->delete($nik, $role);

        $new_role = new Role();
        $new_role->nik = $nik;
        $new_role->role = $role;
        $result = $new_role->save();

        return $result;
    }
}
