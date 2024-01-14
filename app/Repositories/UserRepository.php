<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepository
{
    public function insert(array $validated): bool;

    public function update(array $validated): bool;
}
