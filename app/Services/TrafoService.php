<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface TrafoService
{
    public function getAll(): Collection;

    // public function register(array $validated): bool;

    // public function updateTrafo(array $validated): bool;

    // public function statusEnum(): array;

    // public function powerUnitEnum(): array;

    // public function registeredUniqueIds(): array;

    // public function registeredQrCodeLinks(): array;

    // public function motorCodes(): array;

    // public function installDismantle(string $dismantle, string $install): void;
}
