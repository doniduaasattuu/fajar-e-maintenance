<?php

namespace App\Repositories;

interface MotorDetailRepository
{
    public function insert(array $validated): bool;

    public function update(array $validated): bool;
}
