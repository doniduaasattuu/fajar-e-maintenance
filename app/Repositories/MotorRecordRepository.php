<?php

namespace App\Repositories;

interface MotorRecordRepository
{
    public function insert(array $validated): bool;
}
