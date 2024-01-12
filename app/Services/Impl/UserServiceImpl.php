<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Services\UserService;
use App\Traits\Utility;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserServiceImpl implements UserService
{
    public string $tableName;

    public function __construct()
    {
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

    public function register(array $validated)
    {
        $user = new User();
        $user->nik = $validated['nik'];
        $user->password = $validated['password'];
        $user->fullname = $validated['fullname'];
        $user->department = $validated['department'];
        $user->phone_number = $validated['phone_number'];
        $user->save();
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

    public function niks(): array
    {
        $niks = User::query()->pluck('nik');
        return $niks->toArray();
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
        return DB::getSchemaBuilder()->getColumnListing($this->tableName);
    }

    public function updateProfile(array $validated): bool
    {
        DB::beginTransaction();

        $nik = $validated['nik'];
        $fullname = $validated['fullname'];
        $department = $validated['department'];
        $phone_number = $validated['phone_number'];
        $new_password = $validated['new_password'];

        $user = User::query()->find($nik);
        $user->fullname = $fullname;
        $user->department = $department;
        $user->phone_number = $phone_number;
        $user->password = $new_password;
        $result = $user->save();

        if ($result) {
            DB::commit();
            return $result;
        } else {
            DB::rollBack();
            return false;
        }
    }
}
