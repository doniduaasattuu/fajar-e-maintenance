<?php

namespace App\Services;

use App\Models\User;

interface UserService
{
    public function login(string $nik, string $password): bool;

    public function registration(User $user): bool;
}
