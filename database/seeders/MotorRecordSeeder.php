<?php

namespace Database\Seeders;

use App\Models\MotorRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotorRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $year = 36;
        $users = User::all();

        for ($i = 0; $i < $year; $i++) {

            $record1 = new MotorRecord();
            $record1->id = uniqid();
            $record1->funcloc = "FP-01-PM3-REL-PPRL-PRAR";
            $record1->motor = "MGM000481";
            $record1->sort_field = "PM3.REEL.PRAR/GM";
            $record1->motor_status = array(0 => "Running", 1 => "Not Running")[rand(0, 1)];
            $record1->cleanliness = "Clean";
            $record1->nipple_grease = "Available";
            $record1->number_of_greasing = rand(3, 8) * 10;
            $record1->temperature_de = rand(3500, 10000) / 100;
            $record1->temperature_body = rand(3500, 10000) / 100;
            $record1->temperature_nde = rand(3500, 10000) / 100;
            $record1->vibration_de_vertical_value = rand(45, 112) / 100;
            $record1->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record1->vibration_de_horizontal_value = rand(45, 112) / 100;
            $record1->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record1->vibration_de_axial_value = rand(45, 112) / 100;
            $record1->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record1->vibration_de_frame_value = rand(45, 112) / 100;
            $record1->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record1->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
            $record1->vibration_nde_vertical_value = rand(45, 112) / 100;
            $record1->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record1->vibration_nde_horizontal_value = rand(45, 112) / 100;
            $record1->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record1->vibration_nde_frame_value = rand(45, 112) / 100;
            $record1->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record1->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
            $record1->nik = $users[rand(0, sizeof($users) - 1)]->nik;
            $record1->created_at = Carbon::now()->addMonths(- ($year - $i));
            $record1->save();

            $record2 = new MotorRecord();
            $record2->id = uniqid();
            $record2->funcloc = "FP-01-SP3-RJS-T092-P092";
            $record2->motor = "EMO000426";
            $record2->sort_field = "PM3.REEL.PRAR/GM";
            $record2->motor_status = array(0 => "Running", 1 => "Not Running")[rand(0, 1)];
            $record2->cleanliness = "Clean";
            $record2->nipple_grease = "Available";
            $record2->number_of_greasing = rand(3, 8) * 10;
            $record2->temperature_de = rand(3500, 10000) / 100;
            $record2->temperature_body = rand(3500, 10000) / 100;
            $record2->temperature_nde = rand(3500, 10000) / 100;
            $record2->vibration_de_vertical_value = rand(45, 112) / 100;
            $record2->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record2->vibration_de_horizontal_value = rand(45, 112) / 100;
            $record2->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record2->vibration_de_axial_value = rand(45, 112) / 100;
            $record2->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record2->vibration_de_frame_value = rand(45, 112) / 100;
            $record2->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record2->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
            $record2->vibration_nde_vertical_value = rand(45, 112) / 100;
            $record2->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record2->vibration_nde_horizontal_value = rand(45, 112) / 100;
            $record2->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record2->vibration_nde_frame_value = rand(45, 112) / 100;
            $record2->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
            $record2->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
            $record2->nik = $users[rand(0, sizeof($users) - 1)]->nik;
            $record2->created_at = Carbon::now()->addMonths(- ($year - $i));
            $record2->save();
        }
    }
}
