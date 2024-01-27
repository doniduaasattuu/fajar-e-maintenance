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

    private function getEquipmentId(string $qr_code_link): string
    {
        $equipment_id = explode('=', $qr_code_link)[1];
        return $equipment_id;
    }

    private function getEquipmentType(string $equipment_id): string
    {
        $equipment_type = preg_replace('/[0-9]/i', '', $equipment_id);
        return $equipment_type;
    }

    private function getEquipmentCode(string $equipment): string
    {
        $equipment_code = preg_replace('/[0-9]/i', '', $equipment);
        return $equipment_code;
    }
}
