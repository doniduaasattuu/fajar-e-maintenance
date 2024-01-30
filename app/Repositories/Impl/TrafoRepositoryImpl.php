<?php

namespace App\Repositories\Impl;

use App\Models\Trafo;
use App\Repositories\TrafoRepository;
use App\Traits\Utility;
use Carbon\Carbon;

class TrafoRepositoryImpl implements TrafoRepository
{
    use Utility;

    public function insert(array $validated): bool
    {
        $trafo = new Trafo();
        $this->dataAssigment($trafo, $validated);
        $trafo->created_at = Carbon::now()->toDateTimeString();
        $trafo->updated_at = Carbon::now()->toDateTimeString();
        return $trafo->save();
    }

    public function update(array $validated): bool
    {
        $id = $validated['id'];
        $trafo = Trafo::query()->find($id);
        $this->dataAssigment($trafo, $validated);
        $trafo->updated_at = Carbon::now()->toDateTimeString();
        return $trafo->save();
    }
}
