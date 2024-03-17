<?php

namespace Database\Seeders;

use App\Models\Motor;
use App\Models\MotorRecord;
use App\Models\Trafo;
use App\Models\TrafoRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DailyRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::query()->get();
        $trafos = Trafo::query()->get();
        $motors = Motor::query()->get();

        foreach ($motors as $motor) {
            if ($motor->status == 'Installed') {

                $record = new MotorRecord();
                $record->id = uniqid();
                $record->funcloc = $motor->funcloc;
                $record->motor = $motor->id;
                $record->sort_field = $motor->sort_field;
                $record->motor_status = array(0 => "Running", 1 => "Not Running")[rand(0, 1)];
                $record->cleanliness = "Clean";
                $record->nipple_grease = "Available";
                $record->number_of_greasing = rand(3, 8) * 10;
                $record->temperature_de = rand(3500, 10000) / 100;
                $record->temperature_body = rand(3500, 10000) / 100;
                $record->temperature_nde = rand(3500, 10000) / 100;
                $record->vibration_de_vertical_value = rand(45, 112) / 100;
                $record->vibration_de_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record->vibration_de_horizontal_value = rand(45, 112) / 100;
                $record->vibration_de_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record->vibration_de_axial_value = rand(45, 112) / 100;
                $record->vibration_de_axial_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record->vibration_de_frame_value = rand(45, 112) / 100;
                $record->vibration_de_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record->noise_de = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
                $record->vibration_nde_vertical_value = rand(45, 112) / 100;
                $record->vibration_nde_vertical_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record->vibration_nde_horizontal_value = rand(45, 112) / 100;
                $record->vibration_nde_horizontal_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record->vibration_nde_frame_value = rand(45, 112) / 100;
                $record->vibration_nde_frame_desc = array(0 => "Good", 1 => "Satisfactory", 2 => "Unsatisfactory", 3 => "Unacceptable")[rand(0, 2)];
                $record->noise_nde = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
                $record->nik = $users[rand(0, sizeof($users) - 1)]->nik;
                $record->created_at = Carbon::now()->format('d M Y');
                $record->save();
            }
        }

        foreach ($trafos as $trafo) {
            if ($trafo->status == 'Installed') {

                $record = new TrafoRecord();
                $record->id = uniqid();
                $record->funcloc = $trafo->funcloc;
                $record->trafo = $trafo->id;
                $record->sort_field = $trafo->sort_field;
                $record->trafo_status = array(0 => "Online", 1 => "Offline")[rand(0, 1)];
                $record->primary_current_phase_r = rand(43, 60);
                $record->primary_current_phase_s = rand(43, 60);
                $record->primary_current_phase_t = rand(43, 60);
                $record->secondary_current_phase_r = rand(1050, 1083);
                $record->secondary_current_phase_s = rand(1050, 1083);
                $record->secondary_current_phase_t = rand(1050, 1083);
                $record->primary_voltage = rand(19500, 20000);
                $record->secondary_voltage = rand(375, 400);
                $record->cleanliness = array(0 => 'Clean', 1 => 'Dirty')[rand(0, 1)];
                $record->oil_temperature = rand(3750, 6000) / 100;
                $record->winding_temperature = rand(3750, 6000) / 100;
                $record->noise = array(0 => 'Normal', 1 => 'Abnormal')[rand(0, 1)];
                $record->silica_gel = array(0 => 'Good', 1 => 'Satisfactory', 2 => 'Unsatisfactory', 3 => 'Unacceptable')[rand(0, 1)];
                $record->earthing_connection = array(0 => 'No loose', 1 => 'Loose')[rand(0, 1)];
                $record->oil_leakage = array(0 => 'No leaks', 1 => 'Leaks')[rand(0, 1)];
                $record->oil_level = rand(70, 88);
                $record->blower_condition = array(0 => 'Good', 1 => 'Not good')[rand(0, 1)];
                $record->nik = $users[rand(0, sizeof($users) - 1)]->nik;
                $record->created_at = Carbon::now()->format('d M Y');
                $record->save();
            }
        }
    }
}
