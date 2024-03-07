<?php

namespace App\Traits;

use App\Models\Funcloc;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait Utility
{
    public array $equipmentStatus = ['Installed', 'Available', 'Repaired'];

    public static function getColumns(string $table, array $skipped = [])
    {
        $columns =  DB::getSchemaBuilder()->getColumnListing($table);
        return array_values(array_diff($columns, $skipped));
    }

    public static function getEquipmentType(string $equipment_id)
    {
        return preg_replace('/[0-9]/i', '', $equipment_id);
    }

    public static function getEquipmentUniqueId(string $equipment_id)
    {
        return preg_replace('/[a-zA-Z\-]/i', '', $equipment_id);
    }

    // ===================
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

    private function getEquipmentCode(string $equipment): string
    {
        $equipment_code = preg_replace('/[0-9]/i', '', $equipment);
        return $equipment_code;
    }

    private function motorCodes()
    {;
    }

    // TREND
    public function getValueOf(Collection $trends, $column): Collection
    {
        $data = [];

        if ($column == 'created_at') {
            foreach ($trends as $trend) {

                array_push($data, $this->formatDDMMYY($trend->$column));
            }
        } else if ($column == 'nik') {

            foreach ($trends as $trend) {
                $user = User::query()->find($trend->$column);
                array_push($data, $user->abbreviated_name);
            }
        } else {
            foreach ($trends as $trend) {
                array_push($data, $trend->$column);
            }
        }

        return collect($data);
    }

    public function formatDDMMYY(string $date)
    {
        $dates = explode('-', Carbon::create($date)->toDateString());
        $ddmmyy = "$dates[2]/$dates[1]/" . substr($dates[0], 2, 3);

        return $ddmmyy;
    }

    public static function areas(): array
    {
        $funcloc = Funcloc::query()->pluck('id');
        $areas = $funcloc->map(function ($value, $key) {
            return explode('-', $value)[2];
        });

        $areasUnique = $areas->unique()->values()->all();
        return $areasUnique;
    }
}
