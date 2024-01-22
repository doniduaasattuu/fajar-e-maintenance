<?php

namespace App\Services\Impl;

use App\Models\Role;
use App\Repositories\RoleRepository;
use App\Services\RoleService;

class RoleServiceImpl implements RoleService
{
    private RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function assigment(string $validated_nik, string $validated_role): bool
    {
        $role = new Role();
        $role->nik = $validated_nik;
        $role->role = $validated_role;
        $result = $role->save();

        return $result;
    }

    public function deleteDbAdmin(string $nik): bool
    {
        return $this->roleRepository->delete($nik, 'db_admin');
    }

    public function assignDbAdmin(string $nik): bool
    {
        return $this->roleRepository->assign($nik, 'db_admin');
    }

    public function deleteAdmin(string $nik): bool
    {
        return $this->roleRepository->delete($nik, 'admin');
    }

    public function assignAdmin(string $nik): bool
    {
        return $this->roleRepository->assign($nik, 'admin');
    }
}
