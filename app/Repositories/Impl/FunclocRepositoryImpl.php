<?php

namespace App\Repositories\Impl;

use App\Models\Funcloc;
use App\Repositories\FunclocRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FunclocRepositoryImpl implements FunclocRepository
{
    public array $tableColumns;

    public function __construct()
    {
        $this->tableColumns = DB::getSchemaBuilder()->getColumnListing('funclocs');
    }

    private function adjustment($funcloc, $validated)
    {
        foreach ($validated as $key => $value) {
            $funcloc->$key = $value;
        }
    }

    public function insert(array $validated): bool
    {
        $funcloc = new Funcloc();
        $this->adjustment($funcloc, $validated);
        return $funcloc->save();
    }

    public function update(array $validated): bool
    {
        $id = $validated['id'];
        $funcloc = Funcloc::query()->find($id);
        $this->adjustment($funcloc, $validated);
        $funcloc->updated_at = Carbon::now()->toDateTimeString();
        return $funcloc->save();
    }
}
