<?php

namespace App\Services\Impl;

use App\Models\MotorRecord;
use App\Repositories\MotorRecordRepository;
use App\Services\MotorRecordService;
use App\Traits\Utility;

class MotorRecordServiceImpl implements MotorRecordService
{
    use Utility;

    private MotorRecordRepository $motorRecordRepository;

    public function __construct(MotorRecordRepository $motorRecordRepository)
    {
        $this->motorRecordRepository = $motorRecordRepository;
    }

    public function save(array $validated): bool
    {
        return $this->motorRecordRepository->insert($validated);
    }

    public function update(MotorRecord $record, array $validated): bool
    {
        $this->dataAssigment($record, $validated);
        $result = $record->update();

        return $result;
    }
}
