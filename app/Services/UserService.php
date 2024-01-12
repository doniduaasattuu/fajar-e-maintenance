<?php

namespace App\Services;

use App\Models\User;
use Exception;

interface UserService
{
    public function login(array $validated): bool;

    public function register(array $validated);

    public function departments(): array;

    public function niks(): array;

    public function userExists(string $nik): bool;
}
