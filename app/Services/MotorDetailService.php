<?php

namespace App\Services;

interface MotorDetailService
{
    public function register(array $validated): bool;

    public function updateMotorDetail(array $validated): bool;
}
