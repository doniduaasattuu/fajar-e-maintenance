<?php

namespace App\Services;

use App\Models\MotorDetails;
use App\Traits\Utility;
use Illuminate\Database\Eloquent\Collection;

interface MotorService
{
    public function getAll(): Collection;

    public function register(array $validated): bool;

    public function getTableColumns(): array;

    public function registeredMotors(): array;

    public function updateMotor(array $validated): bool;

    public function statusEnum(): array;

    public function powerUnitEnum(): array;

    public function electricalCurrentEnum(): array;

    public function nippleGreaseEnum(): array;

    public function coolingFanEnum(): array;

    public function mountingEnum(): array;

    public function motorStatusEnum(): array;

    public function vibrationDescriptionEnum(): array;

    public function cleanlinessEnum(): array;

    public function noiseEnum(): array;

    public function registeredUniqueIds(): array;

    public function registeredQrCodeLinks(): array;

    public function motorCodes(): array;

    public function installDismantle(string $dismantle, string $install): void;
}
