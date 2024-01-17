<?php

namespace App\Services;

use App\Models\MotorDetails;
use Illuminate\Database\Eloquent\Collection;

interface MotorService
{
    public function getAll(): Collection;

    public function register(array $validated): bool;

    public function getTableColumns(): array;

    public function registeredMotors(): array;

    public function updateMotor(array $validated): bool;

    public function statusEnum(): array;

    public function registeredUniqueIds(): array;

    public function registeredQrCodeLinks(): array;

    public function motorCodes(): array;
}
