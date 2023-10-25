<?php

namespace Database\Seeders;

use App\Models\DataRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("data_records")->truncate();
        $fullname = User::query()->find("55000154")->fullname;

        $year = 30;

        for ($i = 0; $i < $year; $i++) {
            $data_record = new DataRecord();
            $data_record->funcloc = "FP-01-SP3-RJS-T092-P092";
            $data_record->emo = "EMO000426";
            $data_record->motor_status = "Running";
            $data_record->clean_status = "Clean";
            $data_record->nipple_grease = "Available";
            $data_record->number_of_greasing = rand(3, 8) * 10;
            $data_record->temperature_a = rand(35, 100);
            $data_record->temperature_b = rand(35, 100);
            $data_record->temperature_c = rand(35, 100);
            $data_record->temperature_d = rand(35, 100);
            $data_record->vibration_value_de = rand(1, 112) / 100;
            $data_record->vibration_de = "Normal";
            $data_record->vibration_value_nde = rand(1, 112) / 100;
            $data_record->vibration_nde = "Normal";
            $data_record->created_at = Carbon::now()->addMonths(- ($year - $i));
            $data_record->checked_by = $fullname;
            $data_record->save();

            $data_record1 = new DataRecord();
            $data_record1->funcloc = "FP-01-PM3-REL-PPRL-PRAR";
            $data_record1->emo = "MGM000481";
            $data_record1->motor_status = "Running";
            $data_record1->clean_status = "Clean";
            $data_record1->nipple_grease = "Not Available";
            $data_record1->temperature_a = rand(35, 100);
            $data_record1->temperature_b = rand(35, 100);
            $data_record1->temperature_c = rand(35, 100);
            $data_record1->temperature_d = rand(35, 100);
            $data_record1->vibration_value_de = rand(1, 112) / 100;
            $data_record1->vibration_de = "Normal";
            $data_record1->vibration_value_nde = rand(1, 112) / 100;
            $data_record1->vibration_nde = "Normal";
            $data_record1->created_at = Carbon::now()->addMonths(- ($year - $i));
            $data_record1->checked_by = $fullname;
            $data_record1->save();

            $data_record2 = new DataRecord();
            $data_record2->funcloc = "FP-01-CH3-ALM-T089-P085";
            $data_record2->emo = "EMO001056";
            $data_record2->motor_status = "Running";
            $data_record2->clean_status = "Clean";
            $data_record2->nipple_grease = "Not Available";
            $data_record2->temperature_a = rand(35, 100);
            $data_record2->temperature_b = rand(35, 100);
            $data_record2->temperature_c = rand(35, 100);
            $data_record2->temperature_d = rand(35, 100);
            $data_record2->vibration_value_de = rand(1, 112) / 100;
            $data_record2->vibration_de = "Normal";
            $data_record2->vibration_value_nde = rand(1, 112) / 100;
            $data_record2->vibration_nde = "Normal";
            $data_record2->created_at = Carbon::now()->addMonths(- ($year - $i));
            $data_record2->checked_by = $fullname;
            $data_record2->save();
        }
    }
}
