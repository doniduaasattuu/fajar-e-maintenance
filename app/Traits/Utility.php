<?php

namespace App\Traits;

use App\Models\Funcloc;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait Utility
{
    public static function getExistUser()
    {
        $users = User::get();

        $users = $users->map(function ($value, $key) {
            return "$value->nik";
        });
        return $users;
    }

    public static function getEnumValue(string $table, string $column)
    {
        switch ($table) {

            case ('user'):
                switch ($column) {
                    case ('department'):
                        return ['EI1', 'EI2', 'EI3', 'EI4', 'EI5', 'EI6', 'EI7'];
                        break;

                    default:
                        [];
                        break;
                }

            case ('motor'):
                switch ($column) {
                    case ('power_unit'):
                        return  ['kW', 'HP'];
                        break;
                    case ('electrical_current'):
                        return ['AC', 'DC'];
                        break;
                    case ('nipple_grease'):
                        return ['Available', 'Not Available'];
                        break;
                    case ('cooling_fan'):
                        return ['Internal', 'External', 'Not Available'];
                        break;
                    case ('mounting'):
                        return ['Horizontal', 'Vertical', 'V/H', 'MGM'];
                        break;
                    default:
                        [];
                        break;
                }
                break;

            case ('trafo'):
                switch ($column) {
                    case ('power_unit'):
                        return  ['VA', 'kVA', 'MVA'];
                        break;
                    case ('type'):
                        return  ['Step up', 'Step down'];
                        break;
                    default:
                        [];
                        break;
                }
                break;

            case ('equipment'):
                switch ($column) {
                    case ('status'):
                        return ['Installed', 'Available', 'Repaired'];
                        break;
                    default:
                        [];
                        break;
                }
        }
    }

    public static function firstSlotUnique($table)
    {
        $pluck = DB::table($table)->pluck('unique_id')->sort();
        $unique =  $pluck->values()->all();

        if (count($unique) < 1) {
            return 1;
        }

        for ($i = 0; $i < count($unique); $i++) {
            if (array_key_exists($i + 1, $unique)) {
                if ($unique[$i] + 1 != $unique[$i + 1]) {
                    return $unique[$i] + 1;
                }
            } else {
                return $unique[$i] + 1;
            }
        }
    }

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

    private static function getEquipmentCode(string $equipment): string
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
