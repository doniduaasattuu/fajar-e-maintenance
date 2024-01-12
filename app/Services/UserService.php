<?php

namespace App\Services;

use App\Models\User;

interface UserService
{
    public function login(array $validated): bool;

    public function register(array $validated);

    public function departments(): array;

    public function niks(): array;

    public function userExists(string $nik): bool;

    public function user(string $nik): User;

    public function getTableColumns(): array;

    public function updateProfile(array $validated): bool;
}
