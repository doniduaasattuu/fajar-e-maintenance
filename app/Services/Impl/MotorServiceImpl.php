<?php

namespace App\Services\Impl;

use App\Models\Motor;
use App\Repositories\MotorRepository;
use App\Services\MotorService;
use Illuminate\Database\Eloquent\Collection;

class MotorServiceImpl implements MotorService
{
    private MotorRepository $motorRepository;

    public function __construct(MotorRepository $motorRepository)
    {
        $this->motorRepository = $motorRepository;
    }

    public function getAll(): Collection
    {
        $motors = Motor::query()->get();
        return $motors;
    }

    public function getTableColumns(): array
    {
        $tableColumns = $this->motorRepository->tableColumns;
        return $tableColumns;
    }

    public function registeredMotors(): array
    {
        $motors_id = Motor::query()->pluck('id');
        return $motors_id->toArray();
    }

    public function register(array $validated): bool
    {
        return $this->motorRepository->insert($validated);
    }

    public function updateMotor(array $validated): bool
    {
        return $this->motorRepository->update($validated);
    }

    public function statusEnum(): array
    {
        return [
            'Installed',
            'Repaired',
            'Available'
        ];
    }

    public function registeredUniqueIds(): array
    {
        $uniqueIds = Motor::query()->pluck('unique_id');
        return $uniqueIds->toArray();
    }

    public function registeredQrCodeLinks(): array
    {
        $qrCodeLinks = Motor::query()->pluck('qr_code_link');
        return $qrCodeLinks->toArray();
    }
}
