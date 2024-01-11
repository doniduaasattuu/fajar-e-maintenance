<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Services\UserService;
use Exception;

class UserServiceImpl implements UserService
{
    public function login(string $nik, string $password): bool
    {
        $user = User::query()->find($nik);

        if (!is_null($user)) {
            return $user->password == $password;
        } else {
            return false;
        }
    }

    public function register(array $data): bool|Exception
    {
        // $userExist = User::query()->find($user->id);

        if (is_null(true)) {
            // return $user->save();
        } else {
            return false;
        }
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
}
