<?php

namespace App\Services;

use App\Models\MotorRecord;

interface MotorRecordService
{
    public function save(array $validated): bool;

    public function update(MotorRecord $record, array $validated): bool;
}
