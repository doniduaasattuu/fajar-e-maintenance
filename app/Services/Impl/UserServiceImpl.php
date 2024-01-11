<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Services\UserService;

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

    public function registration(User $user): bool
    {
        $userExist = User::query()->find($user->id);

        if (is_null($userExist)) {
            return $user->save();
        } else {
            return false;
        }
    }
}
