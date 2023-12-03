<?php

namespace Database\Seeders;

use App\Models\Emo;
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

        // $nik = User::query()->find("55000135")->nik;
        $users = User::query()->get();
        $emo = Emo::query()->find("EMO000426");

        $year = 36;

        for ($i = 0; $i < $year; $i++) {

            // P-70 SP3
            $data_record = new EmoRecord();
            $data_record->funcloc = $emo->funcloc;
            $data_record->emo = $emo->id;
            $data_record->sort_field = $emo->sort_field;
            $data_record->clean_status = "Clean";
            $data_record->nipple_grease = "Available";

            if ($i == 26) {
                $data_record->motor_status = "Running";
                $data_record->comment = "Fan gesek dengan cover";
                $data_record->nik = $users[rand(0, sizeof($users) - 1)]->nik;
                $data_record->created_at = Carbon::now()->addMonths(- ($year - $i))->addDays(-7);
                $data_record->number_of_greasing = rand(3, 8) * 10;

                $data_record->temperature_de = rand(35, 101);
                $data_record->temperature_body = rand(35, 101);
                $data_record->temperature_nde = rand(35, 101);

                $data_record->vibration_de_vertical_value = rand(45, 112) / 100;
                $data_record->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_de_horizontal_value = rand(45, 112) / 100;
                $data_record->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_de_axial_value = rand(45, 112) / 100;
                $data_record->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_de_frame_value = rand(45, 112) / 100;
                $data_record->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

                $data_record->vibration_nde_vertical_value = rand(45, 112) / 100;
                $data_record->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_nde_horizontal_value = rand(45, 112) / 100;
                $data_record->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_nde_frame_value = rand(45, 112) / 100;
                $data_record->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
            } else if ($i == 29) {
                $data_record->motor_status = "Running";
                $data_record->comment = "Plastik terminal perlu di ganti";
                $data_record->nik = "31100171";
                $data_record->created_at = Carbon::now()->addMonths(- ($year - $i))->addDays(-3);
                $data_record->number_of_greasing = rand(3, 8) * 10;

                $data_record->temperature_de = rand(35, 101);
                $data_record->temperature_body = rand(35, 101);
                $data_record->temperature_nde = rand(35, 101);

                $data_record->vibration_de_vertical_value = rand(45, 112) / 100;
                $data_record->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_de_horizontal_value = rand(45, 112) / 100;
                $data_record->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_de_axial_value = rand(45, 112) / 100;
                $data_record->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_de_frame_value = rand(45, 112) / 100;
                $data_record->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

                $data_record->vibration_nde_vertical_value = rand(45, 112) / 100;
                $data_record->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_nde_horizontal_value = rand(45, 112) / 100;
                $data_record->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_nde_frame_value = rand(45, 112) / 100;
                $data_record->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
            } else if ($i == 30) {
                $data_record->motor_status = "Running";
                $data_record->comment = "Pipa buburan bocor mengenai motor";
                $data_record->nik = "55000092";
                $data_record->created_at = Carbon::now()->addMonths(- ($year - $i))->addDays(10);
                $data_record->number_of_greasing = rand(3, 8) * 10;

                $data_record->temperature_de = rand(35, 101);
                $data_record->temperature_body = rand(35, 101);
                $data_record->temperature_nde = rand(35, 101);

                $data_record->vibration_de_vertical_value = rand(45, 112) / 100;
                $data_record->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_de_horizontal_value = rand(45, 112) / 100;
                $data_record->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_de_axial_value = rand(45, 112) / 100;
                $data_record->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_de_frame_value = rand(45, 112) / 100;
                $data_record->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

                $data_record->vibration_nde_vertical_value = rand(45, 112) / 100;
                $data_record->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_nde_horizontal_value = rand(45, 112) / 100;
                $data_record->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_nde_frame_value = rand(45, 112) / 100;
                $data_record->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
            } else if ($i == 32) {
                $data_record->motor_status = "Not Running";
                $data_record->comment = null;
                $data_record->nik = "31100156";
                $data_record->created_at = Carbon::now()->addMonths(- ($year - $i))->addDays(7);
                $data_record->number_of_greasing = rand(3, 8) * 10;

                $data_record->temperature_de = 0;
                $data_record->temperature_body = 0;
                $data_record->temperature_nde = 0;

                $data_record->vibration_de_vertical_value = 0;
                $data_record->vibration_de_vertical_desc = null;
                $data_record->vibration_de_horizontal_value = 0;
                $data_record->vibration_de_horizontal_desc = null;
                $data_record->vibration_de_axial_value = 0;
                $data_record->vibration_de_axial_desc = null;
                $data_record->vibration_de_frame_value = 0;
                $data_record->vibration_de_frame_desc = null;
                $data_record->noise_de = "Normal";

                $data_record->vibration_nde_vertical_value = 0;
                $data_record->vibration_nde_vertical_desc = null;
                $data_record->vibration_nde_horizontal_value = 0;
                $data_record->vibration_nde_horizontal_desc = null;
                $data_record->vibration_nde_frame_value = 0;
                $data_record->vibration_nde_frame_desc = null;
                $data_record->noise_nde = "Normal";
            } else {
                $data_record->motor_status = "Running";
                $data_record->comment = null;
                $data_record->nik = $users[rand(0, sizeof($users) - 1)]->nik;
                $data_record->created_at = Carbon::now()->addMonths(- ($year - $i));
                $data_record->number_of_greasing = rand(3, 8) * 10;

                $data_record->temperature_de = rand(35, 101);
                $data_record->temperature_body = rand(35, 101);
                $data_record->temperature_nde = rand(35, 101);

                $data_record->vibration_de_vertical_value = rand(45, 112) / 100;
                $data_record->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_de_horizontal_value = rand(45, 112) / 100;
                $data_record->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_de_axial_value = rand(45, 112) / 100;
                $data_record->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_de_frame_value = rand(45, 112) / 100;
                $data_record->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

                $data_record->vibration_nde_vertical_value = rand(45, 112) / 100;
                $data_record->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_nde_horizontal_value = rand(45, 112) / 100;
                $data_record->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->vibration_nde_frame_value = rand(45, 112) / 100;
                $data_record->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $data_record->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
            }
            $data_record->save();

            // PRIMARY ARM POPE REEL
            $data_record1 = new EmoRecord();
            $data_record1->funcloc = "FP-01-PM3-REL-PPRL-PRAR";
            $data_record1->emo = "MGM000481";
            $data_record1->sort_field = "PM3.REEL.PRAR/GM";
            $data_record1->motor_status = "Running";
            $data_record1->clean_status = "Clean";
            $data_record1->nipple_grease = "Not Available";
            $data_record1->number_of_greasing = rand(2, 4) * 10;
            $data_record1->temperature_de = rand(35, 101);
            $data_record1->temperature_body = rand(35, 101);
            $data_record1->temperature_nde = rand(35, 101);
            $data_record1->vibration_de_vertical_value = rand(45, 112) / 100;
            $data_record1->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record1->vibration_de_horizontal_value = rand(45, 112) / 100;
            $data_record1->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record1->vibration_de_axial_value = rand(45, 112) / 100;
            $data_record1->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record1->vibration_de_frame_value = rand(45, 112) / 100;
            $data_record1->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record1->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record1->vibration_nde_vertical_value = rand(45, 112) / 100;
            $data_record1->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record1->vibration_nde_horizontal_value = rand(45, 112) / 100;
            $data_record1->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record1->vibration_nde_frame_value = rand(45, 112) / 100;
            $data_record1->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record1->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record1->created_at = Carbon::now()->addMonths(- ($year - $i));
            $data_record1->nik = $users[rand(0, sizeof($users) - 1)]->nik;
            $data_record1->save();

            // C-06 SP3
            $data_record2 = new EmoRecord();
            $data_record2->funcloc = "FP-01-CH3-ALM-T089-P085";
            $data_record2->emo = "EMO001056";
            $data_record2->sort_field = "CH3.C06/M";
            $data_record2->motor_status = "Running";
            $data_record2->clean_status = "Clean";
            $data_record2->nipple_grease = "Not Available";
            $data_record2->number_of_greasing = rand(3, 8) * 10;
            $data_record2->temperature_de = rand(35, 101);
            $data_record2->temperature_body = rand(35, 101);
            $data_record2->temperature_nde = rand(35, 101);
            $data_record2->vibration_de_vertical_value = rand(45, 112) / 100;
            $data_record2->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record2->vibration_de_horizontal_value = rand(45, 112) / 100;
            $data_record2->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record2->vibration_de_axial_value = rand(45, 112) / 100;
            $data_record2->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record2->vibration_de_frame_value = rand(45, 112) / 100;
            $data_record2->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record2->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record2->vibration_nde_vertical_value = rand(45, 112) / 100;
            $data_record2->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record2->vibration_nde_horizontal_value = rand(45, 112) / 100;
            $data_record2->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record2->vibration_nde_frame_value = rand(45, 112) / 100;
            $data_record2->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record2->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record2->created_at = Carbon::now()->addMonths(- ($year - $i));
            $data_record2->nik = $users[rand(0, sizeof($users) - 1)]->nik;
            $data_record2->save();

            // P-2-5 PM8
            $data_record3 = new EmoRecord();
            $data_record3->funcloc = "FP-01-PM8-PRS-PRS2-MD05";
            $data_record3->emo = "EMO004493";
            $data_record3->sort_field = "PM8/PRS-PRS2-MD05";
            $data_record3->motor_status = "Running";
            $data_record3->clean_status = "Clean";
            $data_record3->nipple_grease = "Available";
            $data_record3->number_of_greasing = rand(3, 8) * 10;
            $data_record3->temperature_de = rand(35, 101);
            $data_record3->temperature_body = rand(35, 101);
            $data_record3->temperature_nde = rand(35, 101);
            $data_record3->vibration_de_vertical_value = rand(45, 112) / 100;
            $data_record3->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record3->vibration_de_horizontal_value = rand(45, 112) / 100;
            $data_record3->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record3->vibration_de_axial_value = rand(45, 112) / 100;
            $data_record3->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record3->vibration_de_frame_value = rand(45, 112) / 100;
            $data_record3->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record3->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record3->vibration_nde_vertical_value = rand(45, 112) / 100;
            $data_record3->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record3->vibration_nde_horizontal_value = rand(45, 112) / 100;
            $data_record3->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record3->vibration_nde_frame_value = rand(45, 112) / 100;
            $data_record3->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record3->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record3->created_at = Carbon::now()->addMonths(- ($year - $i));
            $data_record3->nik = $users[rand(0, sizeof($users) - 1)]->nik;
            $data_record3->save();

            // RF-07 PM1
            $data_record4 = new EmoRecord();
            $data_record4->funcloc = "FP-01-SP1-UKP-RF07";
            $data_record4->emo = "EMO003963";
            $data_record4->sort_field = "SP1.MW.DDR1/M";
            $data_record4->motor_status = "Running";
            $data_record4->clean_status = "Clean";
            $data_record4->nipple_grease = "Available";
            $data_record4->number_of_greasing = rand(3, 8) * 10;
            $data_record4->temperature_de = rand(35, 101);
            $data_record4->temperature_body = rand(35, 101);
            $data_record4->temperature_nde = rand(35, 101);
            $data_record4->vibration_de_vertical_value = rand(45, 112) / 100;
            $data_record4->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record4->vibration_de_horizontal_value = rand(45, 112) / 100;
            $data_record4->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record4->vibration_de_axial_value = rand(45, 112) / 100;
            $data_record4->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record4->vibration_de_frame_value = rand(45, 112) / 100;
            $data_record4->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record4->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record4->vibration_nde_vertical_value = rand(45, 112) / 100;
            $data_record4->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record4->vibration_nde_horizontal_value = rand(45, 112) / 100;
            $data_record4->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record4->vibration_nde_frame_value = rand(45, 112) / 100;
            $data_record4->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record4->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record4->created_at = Carbon::now()->addMonths(- ($year - $i));
            $data_record4->nik = $users[rand(0, sizeof($users) - 1)]->nik;
            $data_record4->save();

            // RF-04 SP1
            $data_record5 = new EmoRecord();
            $data_record5->funcloc = "FP-01-SP1-MXW-RF04";
            $data_record5->emo = "EMO003604";
            $data_record5->sort_field = "SP1.MXW.RF04.KNF/M";
            $data_record5->motor_status = "Running";
            $data_record5->clean_status = "Clean";
            $data_record5->nipple_grease = "Available";
            $data_record5->number_of_greasing = rand(3, 8) * 10;
            $data_record5->temperature_de = rand(35, 101);
            $data_record5->temperature_body = rand(35, 101);
            $data_record5->temperature_nde = rand(35, 101);
            $data_record5->vibration_de_vertical_value = rand(45, 112) / 100;
            $data_record5->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record5->vibration_de_horizontal_value = rand(45, 112) / 100;
            $data_record5->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record5->vibration_de_axial_value = rand(45, 112) / 100;
            $data_record5->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record5->vibration_de_frame_value = rand(45, 112) / 100;
            $data_record5->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record5->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record5->vibration_nde_vertical_value = rand(45, 112) / 100;
            $data_record5->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record5->vibration_nde_horizontal_value = rand(45, 112) / 100;
            $data_record5->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record5->vibration_nde_frame_value = rand(45, 112) / 100;
            $data_record5->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record5->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record5->created_at = Carbon::now()->addMonths(- ($year - $i));
            $data_record5->nik = $users[rand(0, sizeof($users) - 1)]->nik;
            $data_record5->save();

            // M-21 SP5
            $data_record6 = new EmoRecord();
            $data_record6->funcloc = "FP-01-SP5-OCC-FR01";
            $data_record6->emo = "EMO001092";
            $data_record6->sort_field = "SP5.M-21/M";
            $data_record6->motor_status = "Running";
            $data_record6->clean_status = "Clean";
            $data_record6->nipple_grease = "Available";
            $data_record6->number_of_greasing = rand(3, 8) * 10;
            $data_record6->temperature_de = rand(35, 101);
            $data_record6->temperature_body = rand(35, 101);
            $data_record6->temperature_nde = rand(35, 101);
            $data_record6->vibration_de_vertical_value = rand(45, 112) / 100;
            $data_record6->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record6->vibration_de_horizontal_value = rand(45, 112) / 100;
            $data_record6->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record6->vibration_de_axial_value = rand(45, 112) / 100;
            $data_record6->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record6->vibration_de_frame_value = rand(45, 112) / 100;
            $data_record6->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record6->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record6->vibration_nde_vertical_value = rand(45, 112) / 100;
            $data_record6->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record6->vibration_nde_horizontal_value = rand(45, 112) / 100;
            $data_record6->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record6->vibration_nde_frame_value = rand(45, 112) / 100;
            $data_record6->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record6->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record6->created_at = Carbon::now()->addMonths(- ($year - $i));
            $data_record6->nik = $users[rand(0, sizeof($users) - 1)]->nik;
            $data_record6->save();

            // RT-71-1 SP7
            $data_record7 = new EmoRecord();
            $data_record7->funcloc = "FP-01-PM7-VAS-VP13";
            $data_record7->emo = "EMO005614";
            $data_record7->sort_field = "PM7.VAS/VP-18101000/M";
            $data_record7->motor_status = "Running";
            $data_record7->clean_status = "Clean";
            $data_record7->nipple_grease = "Available";
            $data_record7->number_of_greasing = rand(3, 8) * 10;
            $data_record7->temperature_de = rand(35, 101);
            $data_record7->temperature_body = rand(35, 101);
            $data_record7->temperature_nde = rand(35, 101);
            $data_record7->vibration_de_vertical_value = rand(45, 112) / 100;
            $data_record7->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record7->vibration_de_horizontal_value = rand(45, 112) / 100;
            $data_record7->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record7->vibration_de_axial_value = rand(45, 112) / 100;
            $data_record7->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record7->vibration_de_frame_value = rand(45, 112) / 100;
            $data_record7->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record7->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record7->vibration_nde_vertical_value = rand(45, 112) / 100;
            $data_record7->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record7->vibration_nde_horizontal_value = rand(45, 112) / 100;
            $data_record7->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record7->vibration_nde_frame_value = rand(45, 112) / 100;
            $data_record7->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record7->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record7->created_at = Carbon::now()->addMonths(- ($year - $i));
            $data_record7->nik = $users[rand(0, sizeof($users) - 1)]->nik;
            $data_record7->save();

            // P050 IN1
            $data_record8 = new EmoRecord();
            $data_record8->funcloc = "FP-01-IN1-BIF-STDM-P050";
            $data_record8->emo = "EMO002281";
            $data_record8->sort_field = "IN1-BIF-STDM-P050/MBCP1/M-12A";
            $data_record8->motor_status = "Running";
            $data_record8->clean_status = "Clean";
            $data_record8->nipple_grease = "Not Available";
            $data_record8->number_of_greasing = rand(3, 8) * 10;
            $data_record8->temperature_de = rand(35, 101);
            $data_record8->temperature_body = rand(35, 101);
            $data_record8->temperature_nde = rand(35, 101);
            $data_record8->vibration_de_vertical_value = rand(45, 112) / 100;
            $data_record8->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record8->vibration_de_horizontal_value = rand(45, 112) / 100;
            $data_record8->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record8->vibration_de_axial_value = rand(45, 112) / 100;
            $data_record8->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record8->vibration_de_frame_value = rand(45, 112) / 100;
            $data_record8->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record8->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record8->vibration_nde_vertical_value = rand(45, 112) / 100;
            $data_record8->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record8->vibration_nde_horizontal_value = rand(45, 112) / 100;
            $data_record8->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record8->vibration_nde_frame_value = rand(45, 112) / 100;
            $data_record8->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $data_record8->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];

            $data_record8->created_at = Carbon::now()->addMonths(- ($year - $i));
            $data_record8->nik = User::query()->find("55000153")->nik;
            $data_record8->save();
        }
    }
}
