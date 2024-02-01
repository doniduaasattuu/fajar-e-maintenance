<?php

namespace App\Repositories\Impl;

use App\Models\TrafoRecord;
use App\Repositories\TrafoRecordRepository;
use App\Traits\Utility;

class TrafoRecordRepositoryImpl implements TrafoRecordRepository
{
    use Utility;

    public function insert(array $validated): bool
    {
        $motor_record = new TrafoRecord();
        $this->dataAssigment($motor_record, $validated);
        $result = $motor_record->save();

        return $result;
    }
}
