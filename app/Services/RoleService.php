<?php

namespace App\Services;

interface RoleService
{
    public function assigment(string $validated_nik, string $validated_role): bool;
}
