<?php

namespace App\Services\Impl;

use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Traits\Utility;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserServiceImpl implements UserService
{
    use Utility;
    public string $tableName;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->tableName = app(User::class)->getTable();
    }

    public function login(array $validated): bool
    {
        $nik = $validated['nik'];
        $password = $validated['password'];

        $user = User::query()->find($nik);

        if (!is_null($user)) {
            return $user->password === $password;
        } else {
            return false;
        }
    }

    public function register(array $validated): bool
    {
        return $this->userRepository->insert($validated);
    }

    public function departments(): array
    {
        return [
            'EI1',
            'EI2',
            'EI3',
            'EI4',
            'EI5',
            'EI6',
            'EI7',
        ];
    }

    public function registeredNiks(): array
    {
        $niks = User::query()->pluck('nik');
        return $niks->toArray();
    }

    public function availableRole(): array
    {
        return [
            'db_admin',
            'admin'
        ];
    }

    public function userExists(string $nik): bool
    {
        $user = User::query()->find($nik);

        if (!is_null($user)) {
            return true;
        } else {
            return false;
        }
    }

    public function user(string $nik): User
    {
        $user = User::query()->find($nik);
        return $user;
    }

    public function getTableColumns(): array
    {
        $tableColumns = $this->userRepository->tableColumns;
        return $tableColumns;
    }

    public function updateProfile(array $validated): bool
    {
        return $this->userRepository->update($validated);
    }

    public function isAdmin(string $nik): bool
    {
        $user = User::query()->with(['roles'])->find($nik);
        $roles = $user->roles;

        if (!is_null($user) && !is_null($roles)) {

            $roles = $roles->map(function ($value, $key) {
                return $value->role;
            });

            return $roles->contains('admin');
        } else {
            return false;
        }
    }

    public function whoIsAdmin(): Collection
    {
        $adminRoles = Role::query()->with(['User'])->where('role', '=', 'admin')->get();
        return $adminRoles;
    }
}
