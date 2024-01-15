<?php

namespace App\Repositories;

interface MotorRepository
{
    public function insert(array $validated): bool;

    public function update(array $validated): bool;
}
