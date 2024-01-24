<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait Utility
{
    public function getColumns(string $table, array $skipped = [])
    {
        $columns =  DB::getSchemaBuilder()->getColumnListing($table);
        return array_values(array_diff($columns, $skipped));
    }

    public function filterValidatedData(array $validated, array $skipped = [])
    {
        return array_values(array_diff($validated, $skipped));
    }

    private function dataAssigment($model, $validated)
    {
        foreach ($validated as $key => $value) {
            $model->$key = $value;
        }
    }
}
