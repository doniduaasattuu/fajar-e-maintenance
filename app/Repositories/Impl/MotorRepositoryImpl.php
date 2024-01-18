<?php

namespace App\Repositories\Impl;

use App\Models\Motor;
use App\Repositories\MotorRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MotorRepositoryImpl implements MotorRepository
{
    public array $tableColumns;

    public function __construct()
    {
        $this->tableColumns = DB::getSchemaBuilder()->getColumnListing('motors');
    }

    private function adjustment($motor, $validated)
    {
        foreach ($validated as $key => $value) {
            $motor->$key = $value;
        }
    }

    public function insert(array $validated): bool
    {
        $motor = new Motor();
        $this->adjustment($motor, $validated);
        $motor->created_at = Carbon::now()->toDateTimeString();
        $motor->updated_at = Carbon::now()->toDateTimeString();
        return $motor->save();
    }

    public function update(array $validated): bool
    {
        $id = $validated['id'];
        $motor = Motor::query()->find($id);
        $this->adjustment($motor, $validated);
        $motor->updated_at = Carbon::now()->toDateTimeString();
        return $motor->save();
    }
}
