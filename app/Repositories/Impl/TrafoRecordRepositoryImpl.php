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
        $trafo_record = new TrafoRecord();
        $this->dataAssigment($trafo_record, $validated);
        $result = $trafo_record->save();

        return $result;
    }
}
