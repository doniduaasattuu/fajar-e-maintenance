<?php

namespace App\Repositories\Impl;

use App\Models\Finding;
use App\Repositories\FindingRepository;
use App\Traits\Utility;

class FindingRepositoryImpl implements FindingRepository
{
    use Utility;

    public function insert(array $validated): bool
    {
        $finding = new Finding();
        $this->dataAssigment($finding, $validated);
        $result = $finding->save();
        return $result;
    }

    public function update(array $validated): void
    {
        $finding = Finding::query()->find($validated['id']);
        $this->dataAssigment($finding, $validated);
        $finding->update();
    }
}
