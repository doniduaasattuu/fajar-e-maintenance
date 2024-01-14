<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface FunclocService
{
    public function getAll(): Collection;

    public function register(array $validated): bool;

    public function getTableColumns(): array;

    public function registeredFunclocs(): array;

    public function updateFuncloc(array $validated): bool;
}
