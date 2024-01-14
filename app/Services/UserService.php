<?php

namespace App\Services;

use App\Models\User;

interface UserService
{
    public function login(array $validated): bool;

    public function register(array $validated): bool;

    public function userExists(string $nik): bool;

    public function updateProfile(array $validated): bool;

    public function registeredNiks(): array; // return all nik users

    public function departments(): array; // return all department

    public function user(string $nik): User; // return user

    public function getTableColumns(): array; // return table columns
}
