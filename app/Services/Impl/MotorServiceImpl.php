<?php

namespace App\Services\Impl;

use App\Models\Motor;
use App\Models\MotorDetails;
use App\Repositories\MotorRepository;
use App\Services\MotorService;
use App\Traits\Utility;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class MotorServiceImpl implements MotorService
{
    use Utility;

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

    public function powerUnitEnum(): array
    {
        return  [
            'kW',
            'HP'
        ];
    }

    public function electricalCurrentEnum(): array
    {
        return [
            'AC',
            'DC'
        ];
    }

    public function nippleGreaseEnum(): array
    {
        return [
            'Available',
            'Not Available'
        ];
    }

    public function coolingFanEnum(): array
    {
        return [
            'Internal',
            'External',
            'Not Available'
        ];
    }

    public function mountingEnum(): array
    {
        return [
            'Horizontal',
            'Vertical',
            'V/H',
            'MGM',
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

    public function motorCodes(): array
    {
        $allCodes = DB::table('motors')->select(DB::raw('DISTINCT LEFT (id, 3) as codes'))->get();

        $motorCodes = array();
        foreach ($allCodes as $value) {
            array_push($motorCodes, $value->codes);
        }

        return $motorCodes;
    }
}
