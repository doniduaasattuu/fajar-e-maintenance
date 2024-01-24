<?php

namespace App\Repositories\Impl;

use App\Models\MotorRecord;
use App\Repositories\MotorRecordRepository;
use App\Traits\Utility;

class MotorRecordRepositoryImpl implements MotorRecordRepository
{
    use Utility;

    public function insert(array $validated): bool
    {
        $motor_record = new MotorRecord();
        $this->dataAssigment($motor_record, $validated);
        $result = $motor_record->save();

        return $result;
    }
}
