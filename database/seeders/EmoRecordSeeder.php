<?php

namespace Database\Seeders;

use App\Models\EmoRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmoRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("emo_records")->truncate();
        $fullname = User::query()->find("55000154")->fullname;

        $year = 65;

        for ($i = 0; $i < $year; $i++) {
            $data_record = new EmoRecord();
            $data_record->funcloc = "FP-01-SP3-RJS-T092-P092";
            $data_record->emo = "EMO000426";
            $data_record->motor_status = "Running";
            $data_record->clean_status = "Clean";
            $data_record->nipple_grease = "Available";
            $data_record->number_of_greasing = rand(3, 8) * 10;
            $data_record->vibration_value_de = rand(1, 112) / 100;
            $data_record->vibration_de = "Good";
            $data_record->vibration_value_nde = rand(1, 112) / 100;
            if ($i == 4) {
                $data_record->comment = "Plastik terminal perlu diganti";
                $data_record->checked_by = "Edi Supriadi";
                $data_record->created_at = Carbon::now()->addMonths(- ($year - $i))->addDays($i - 7);
                $data_record->temperature_a = rand(35, 150);
                $data_record->temperature_b = rand(35, 150);
                $data_record->temperature_c = rand(35, 150);
                $data_record->temperature_d = rand(35, 150);
            } else if ($i == 20) {
                $data_record->comment = "Fan gesek cover";
                $data_record->checked_by = "Sopo";
                $data_record->created_at = Carbon::now()->addMonths(- ($year - $i))->addDays($i - 5);
                $data_record->temperature_a = rand(35, 150);
                $data_record->temperature_b = rand(35, 150);
                $data_record->temperature_c = rand(35, 150);
                $data_record->temperature_d = rand(35, 150);
            } else if ($i == 32) {
                $data_record->comment = "Bearing belakang noise";
                $data_record->checked_by = "Darminto";
                $data_record->created_at = Carbon::now()->addMonths(- ($year - $i))->addDays($i - 3);
                $data_record->temperature_a = rand(35, 150);
                $data_record->temperature_b = rand(35, 150);
                $data_record->temperature_c = rand(35, 150);
                $data_record->temperature_d = rand(35, 150);
            } else if ($i == 53 || $i == 57) {
                $data_record->comment = null;
                $data_record->checked_by = $fullname;
                $data_record->created_at = Carbon::now()->addMonths(- ($year - $i));
                $data_record->temperature_a = "0";
                $data_record->temperature_b = "0";
                $data_record->temperature_c = "0";
                $data_record->temperature_d = "0";
            } else {
                $data_record->comment = null;
                $data_record->checked_by = $fullname;
                $data_record->created_at = Carbon::now()->addMonths(- ($year - $i));
                $data_record->temperature_a = rand(35, 150);
                $data_record->temperature_b = rand(35, 150);
                $data_record->temperature_c = rand(35, 150);
                $data_record->temperature_d = rand(35, 150);
            }
            $data_record->vibration_nde = "Good";
            $data_record->save();

            // $data_record1 = new EmoRecord();
            // $data_record1->funcloc = "FP-01-PM3-REL-PPRL-PRAR";
            // $data_record1->emo = "MGM000481";
            // $data_record1->motor_status = "Running";
            // $data_record1->clean_status = "Clean";
            // $data_record1->nipple_grease = "Not Available";
            // $data_record1->temperature_a = rand(35, 100);
            // $data_record1->temperature_b = rand(35, 100);
            // $data_record1->temperature_c = rand(35, 100);
            // $data_record1->temperature_d = rand(35, 100);
            // $data_record1->vibration_value_de = rand(1, 112) / 100;
            // $data_record1->vibration_de = "Good";
            // $data_record1->vibration_value_nde = rand(1, 112) / 100;
            // $data_record1->vibration_nde = "Good";
            // $data_record1->created_at = Carbon::now()->addMonths(- ($year - $i));
            // $data_record1->checked_by = $fullname;
            // $data_record1->save();

            // $data_record2 = new EmoRecord();
            // $data_record2->funcloc = "FP-01-CH3-ALM-T089-P085";
            // $data_record2->emo = "EMO001056";
            // $data_record2->motor_status = "Running";
            // $data_record2->clean_status = "Clean";
            // $data_record2->nipple_grease = "Not Available";
            // $data_record2->temperature_a = rand(35, 100);
            // $data_record2->temperature_b = rand(35, 100);
            // $data_record2->temperature_c = rand(35, 100);
            // $data_record2->temperature_d = rand(35, 100);
            // $data_record2->vibration_value_de = rand(1, 112) / 100;
            // $data_record2->vibration_de = "Good";
            // $data_record2->vibration_value_nde = rand(1, 112) / 100;
            // $data_record2->vibration_nde = "Good";
            // $data_record2->created_at = Carbon::now()->addMonths(- ($year - $i));
            // $data_record2->checked_by = $fullname;
            // $data_record2->save();

            // $data_record3 = new EmoRecord();
            // $data_record3->funcloc = "FP-01-PM8-PRS-PRS2-MD05";
            // $data_record3->emo = "EMO004493";
            // $data_record3->motor_status = "Running";
            // $data_record3->clean_status = "Clean";
            // $data_record3->nipple_grease = "Available";
            // $data_record3->number_of_greasing = rand(3, 8) * 10;
            // $data_record3->temperature_a = rand(35, 100);
            // $data_record3->temperature_b = rand(35, 100);
            // $data_record3->temperature_c = rand(35, 100);
            // $data_record3->temperature_d = rand(35, 100);
            // $data_record3->vibration_value_de = rand(1, 112) / 100;
            // $data_record3->vibration_de = "Good";
            // $data_record3->vibration_value_nde = rand(1, 112) / 100;
            // $data_record3->vibration_nde = "Good";
            // $data_record3->created_at = Carbon::now()->addMonths(- ($year - $i));
            // $data_record3->checked_by = $fullname;
            // $data_record3->save();

            // $data_record4 = new EmoRecord();
            // $data_record4->funcloc = "FP-01-SP1-UKP-RF07";
            // $data_record4->emo = "EMO003963";
            // $data_record4->motor_status = "Running";
            // $data_record4->clean_status = "Clean";
            // $data_record4->nipple_grease = "Available";
            // $data_record4->number_of_greasing = rand(3, 8) * 10;
            // $data_record4->temperature_a = rand(35, 100);
            // $data_record4->temperature_b = rand(35, 100);
            // $data_record4->temperature_c = rand(35, 100);
            // $data_record4->temperature_d = rand(35, 100);
            // $data_record4->vibration_value_de = rand(1, 112) / 100;
            // $data_record4->vibration_de = "Good";
            // $data_record4->vibration_value_nde = rand(1, 112) / 100;
            // $data_record4->vibration_nde = "Good";
            // $data_record4->created_at = Carbon::now()->addMonths(- ($year - $i));
            // $data_record4->checked_by = $fullname;
            // $data_record4->save();

            // $data_record5 = new EmoRecord();
            // $data_record5->funcloc = "FP-01-SP1-MXW-RF04";
            // $data_record5->emo = "EMO003604";
            // $data_record5->motor_status = "Running";
            // $data_record5->clean_status = "Clean";
            // $data_record5->nipple_grease = "Available";
            // $data_record5->number_of_greasing = rand(3, 8) * 10;
            // $data_record5->temperature_a = rand(35, 100);
            // $data_record5->temperature_b = rand(35, 100);
            // $data_record5->temperature_c = rand(35, 100);
            // $data_record5->temperature_d = rand(35, 100);
            // $data_record5->vibration_value_de = rand(1, 112) / 100;
            // $data_record5->vibration_de = "Good";
            // $data_record5->vibration_value_nde = rand(1, 112) / 100;
            // $data_record5->vibration_nde = "Good";
            // $data_record5->created_at = Carbon::now()->addMonths(- ($year - $i));
            // $data_record5->checked_by = $fullname;
            // $data_record5->save();

            // $data_record5 = new EmoRecord();
            // $data_record5->funcloc = "FP-01-SP5-OCC-FR01";
            // $data_record5->emo = "EMO001092";
            // $data_record5->motor_status = "Running";
            // $data_record5->clean_status = "Clean";
            // $data_record5->nipple_grease = "Available";
            // $data_record5->number_of_greasing = rand(2, 8) * 10;
            // $data_record5->temperature_a = rand(35, 100);
            // $data_record5->temperature_b = rand(35, 100);
            // $data_record5->temperature_c = rand(35, 100);
            // $data_record5->temperature_d = rand(35, 100);
            // $data_record5->vibration_value_de = rand(1, 112) / 100;
            // $data_record5->vibration_de = "Good";
            // $data_record5->vibration_value_nde = rand(1, 112) / 100;
            // $data_record5->vibration_nde = "Good";
            // $data_record5->created_at = Carbon::now()->addMonths(- ($year - $i));
            // $data_record5->checked_by = $fullname;
            // $data_record5->save();
        }
    }
}
