<?php

namespace Database\Seeders;

use App\Models\DataRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data_record = new DataRecord();
        $data_record->funcloc = "FP-01-SP3-RJS-T092-P092";
        $data_record->emo = "EMO000426";
        $data_record->motor_status = "Running";
        $data_record->clean_status = "Clean";
        $data_record->nipple_grease = "Available";
        $data_record->number_of_greasing = 80;
        $data_record->temperature_a = 69;
        $data_record->temperature_b = 71;
        $data_record->temperature_c = 85;
        $data_record->temperature_d = 65;
        $data_record->vibration_value_de = 0.68;
        $data_record->vibration_de = "Normal";
        $data_record->vibration_value_nde = 0.58;
        $data_record->vibration_nde = "Normal";
        $data_record->created_at = Carbon::now();
        $data_record->checked_by = User::query()->find("55000154")->name;
        $data_record->save();
    }
}
