<?php

namespace App\Repositories\Impl;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class UserRepositoryImpl implements UserRepository
{

    private function adjustment($user, $validated)
    {
        foreach ($validated as $key => $value) {
            if ($key == 'fullname') {
                $user->$key = ucwords(strtolower($value));
            } else {
                $user->$key = $value;
            }
        }
    }

    public function insert(array $validated): bool
    {
        $user = new User();
        $this->adjustment($user, $validated);
        return $user->save();
    }

    public function update(User $user, array $validated): bool
    {
        $this->adjustment($user, $validated);
        return $user->save();
    }
}
