<?php

namespace App\Services\Impl;

use App\Models\Role;
use App\Services\RoleService;

class RoleServiceImpl implements RoleService
{
    public function assigment(string $validated_nik, string $validated_role): bool
    {
        $role = new Role();
        $role->nik = $validated_nik;
        $role->role = $validated_role;
        $result = $role->save();

        return $result;
    }
}
