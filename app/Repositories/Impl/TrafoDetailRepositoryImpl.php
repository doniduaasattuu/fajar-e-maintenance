<?php

namespace App\Repositories\Impl;

use App\Models\TrafoDetails;
use App\Repositories\TrafoDetailRepository;
use App\Traits\Utility;
use Carbon\Carbon;

class TrafoDetailRepositoryImpl implements TrafoDetailRepository
{
    use Utility;

    public function insert(array $validated): bool
    {
        $trafo_detail = new TrafoDetails();
        $this->dataAssigment($trafo_detail, $validated);
        $trafo_detail->created_at = Carbon::now()->toDateTimeString();
        $trafo_detail->updated_at = Carbon::now()->toDateTimeString();
        return $trafo_detail->save();
    }

    public function update(array $validated): bool
    {
        $trafo_detail = TrafoDetails::query()->where('trafo_detail', '=', $validated['trafo_detail'])->first();
        if (!is_null($trafo_detail)) {
            $this->dataAssigment($trafo_detail, $validated);
            $result = $trafo_detail->update();
            return $result;
        } else {
            return $this->insert($validated);
        }
    }
}
