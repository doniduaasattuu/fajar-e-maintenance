<?php

namespace Database\Seeders;

use App\Models\Motor;
use App\Models\MotorRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MotorRecordSeederAll extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('motor_records')->delete();

        $motors = Motor::query()->get();

        foreach ($motors as $motor) {

            $year = 36;
            $users = User::all();

            for ($i = 0; $i < $year; $i++) {

                $record_motor = new MotorRecord();
                $record_motor->id = uniqid();
                $record_motor->funcloc = $motor->funcloc ?? 'FP-01-PM3';
                $record_motor->motor = $motor->id;
                $record_motor->sort_field = $motor->sort_field ?? 'MOTOR';
                $record_motor->motor_status = array(0 => "Running", 1 => "Not Running")[rand(0, 1)];
                $record_motor->cleanliness = array(0 => "Clean", 1 => "Dirty")[rand(0, 1)];
                $record_motor->nipple_grease = array(0 => "Available", 1 => "Not Available")[rand(0, 1)];
                $record_motor->number_of_greasing = rand(3, 8) * 10;
                $record_motor->temperature_de = rand(3500, 10000) / 100;
                $record_motor->temperature_body = rand(3500, 10000) / 100;
                $record_motor->temperature_nde = rand(3500, 10000) / 100;
                $record_motor->vibration_de_vertical_value = rand(45, 112) / 100;
                $record_motor->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record_motor->vibration_de_horizontal_value = rand(45, 112) / 100;
                $record_motor->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record_motor->vibration_de_axial_value = rand(45, 112) / 100;
                $record_motor->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record_motor->vibration_de_frame_value = rand(45, 112) / 100;
                $record_motor->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record_motor->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
                $record_motor->vibration_nde_vertical_value = rand(45, 112) / 100;
                $record_motor->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record_motor->vibration_nde_horizontal_value = rand(45, 112) / 100;
                $record_motor->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record_motor->vibration_nde_frame_value = rand(45, 112) / 100;
                $record_motor->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record_motor->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
                $record_motor->nik = $users[rand(0, sizeof($users) - 1)]->nik;
                $record_motor->created_at = Carbon::now()->addMonths(- ($year - $i));
                $record_motor->save();
            }
        }
    }
}
