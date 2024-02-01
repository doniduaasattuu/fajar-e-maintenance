<?php

namespace App\Services\Impl;

use App\Models\TrafoRecord;
use App\Repositories\TrafoRecordRepository;
use App\Services\TrafoRecordService;
use App\Traits\Utility;

class TrafoRecordServiceImpl implements TrafoRecordService
{
    use Utility;

    private TrafoRecordRepository $trafoRecordRepository;

    public function __construct(TrafoRecordRepository $trafoRecordRepository)
    {
        $this->trafoRecordRepository = $trafoRecordRepository;
    }

    public function save(array $validated): bool
    {
        return $this->trafoRecordRepository->insert($validated);
    }

    public function update(TrafoRecord $record, array $validated): bool
    {
        $this->dataAssigment($record, $validated);
        $result = $record->update();

        return $result;
    }
}
