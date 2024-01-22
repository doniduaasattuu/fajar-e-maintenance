<?php

namespace App\Services;

interface RoleService
{
    public function assigment(string $validated_nik, string $validated_role): bool;

    public function deleteDbAdmin(string $nik): bool;

    public function assignDbAdmin(string $nik): bool;

    public function deleteAdmin(string $nik): bool;

    public function assignAdmin(string $nik): bool;
}
