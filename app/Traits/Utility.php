<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait Utility
{
    public function getTableColumns(string $table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);
    }
}
