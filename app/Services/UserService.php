<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserService
{
    public function login(array $validated): bool;

    public function register(array $validated): bool;

    public function userExists(string $nik): bool;

    public function updateProfile(array $validated): bool;

    public function getAll(): Collection;

    public function registeredNiks(): array; // return all nik users

    public function registeredFullnames(): array; // return all fullname

    public function availableRole(): array;

    public function departments(): array; // return all department

    public function user(string $nik): User; // return user

    public function getTableColumns(): array; // return table columns

    public function isAdmin(string $nik): bool;

    public function isDbAdmin(string $nik): bool;

    public function whoIsAdmin(): Collection;

    public function whoIsDbAdmin(): Collection;
}
