<?php

namespace App\Services;

use App\Models\TrafoRecord;

interface TrafoRecordService
{
    public function save(array $validated): bool;

    public function update(TrafoRecord $record, array $validated): bool;
}
