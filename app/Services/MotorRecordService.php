<?php

namespace App\Services;

interface MotorRecordService
{
    public function save(array $validated): bool;
}
