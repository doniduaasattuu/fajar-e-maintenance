<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait Utility
{
    public static function getColumns(string $table, array $skipped = [])
    {
        $columns =  DB::getSchemaBuilder()->getColumnListing($table);
        return array_values(array_diff($columns, $skipped));
    }
}
