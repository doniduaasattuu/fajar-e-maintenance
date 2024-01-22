<?php

namespace App\Repositories;

interface RoleRepository
{
    public function delete(string $nik, string $role): bool;

    public function assign(string $nik, string $role): bool;
}
