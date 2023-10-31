<?php

namespace Database\Seeders;

use App\Models\DataRecord;
use App\Models\Emo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataRecordSeederAllEquipment extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emos = Emo::query()->select(["id", "funcloc"])->get();
        $fullname = User::query()->find("55000154")->fullname;

        foreach ($emos as $emo_item) {
            $year = 30;
            for ($i = 0; $i < $year; $i++) {
                $data_record = new DataRecord();
                $data_record->funcloc = $emo_item->funcloc;
                $data_record->emo = $emo_item->id;
                $data_record->motor_status = "Running";
                $data_record->clean_status = "Clean";
                $data_record->nipple_grease = "Available";
                $data_record->number_of_greasing = rand(3, 8) * 10;
                $data_record->temperature_a = rand(35, 100);
                $data_record->temperature_b = rand(35, 100);
                $data_record->temperature_c = rand(35, 100);
                $data_record->temperature_d = rand(35, 100);
                $data_record->vibration_value_de = rand(1, 112) / 100;
                $data_record->vibration_de = "Good";
                $data_record->vibration_value_nde = rand(1, 112) / 100;
                $data_record->vibration_nde = "Good";
                $data_record->created_at = Carbon::now()->addMonths(- ($year - $i));
                $data_record->checked_by = $fullname;
                $data_record->save();
            }
        }
    }
}
