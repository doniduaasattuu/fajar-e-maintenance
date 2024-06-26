<?php

namespace Database\Seeders;

use App\Models\TrafoRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrafoRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $year = 99;
        $users = User::all();

        for ($i = 0; $i < $year; $i++) {

            $user = $users[rand(0, sizeof($users) - 1)];

            $record1 = new TrafoRecord();
            $record1->id = uniqid();
            $record1->funcloc = "FP-01-IN1";
            $record1->trafo = "ETF000085";
            $record1->sort_field = "TRAFO PLN";
            $record1->trafo_status = array(0 => "Online", 1 => "Offline")[rand(0, 1)];
            $record1->primary_current_phase_r = rand(43, 60);
            $record1->primary_current_phase_s = rand(43, 60);
            $record1->primary_current_phase_t = rand(43, 60);
            $record1->secondary_current_phase_r = rand(1050, 1083);
            $record1->secondary_current_phase_s = rand(1050, 1083);
            $record1->secondary_current_phase_t = rand(1050, 1083);
            $record1->primary_voltage = rand(19500, 20000);
            $record1->secondary_voltage = rand(375, 400);
            $record1->cleanliness = array(0 => 'Clean', 1 => 'Dirty')[rand(0, 1)];
            $record1->oil_temperature = rand(3750, 6000) / 100;
            $record1->winding_temperature = rand(3750, 6000) / 100;
            $record1->noise = array(0 => 'Normal', 1 => 'Abnormal')[rand(0, 1)];
            $record1->silica_gel = array(0 => 'Good', 1 => 'Satisfactory', 2 => 'Unsatisfactory', 3 => 'Unacceptable')[rand(0, 1)];
            $record1->earthing_connection = array(0 => 'No loose', 1 => 'Loose')[rand(0, 1)];
            $record1->oil_leakage = array(0 => 'No leaks', 1 => 'Leaks')[rand(0, 1)];
            $record1->oil_level = rand(70, 88);
            $record1->blower_condition = array(0 => 'Good', 1 => 'Not good')[rand(0, 1)];
            $record1->department = $user->department;
            $record1->nik = $user->nik;
            $record1->created_at = Carbon::now()->addMonths(- ($year - $i));
            $record1->save();

            $record2 = new TrafoRecord();
            $record2->id = uniqid();
            $record2->funcloc = "FP-01-GT2-TRF-UTY2";
            $record2->trafo = "ETF000120";
            $record2->sort_field = "TR AUX GTG #1 Baru";
            $record2->trafo_status = array(0 => "Online", 1 => "Offline")[rand(0, 1)];
            $record2->primary_current_phase_r = rand(43, 60);
            $record2->primary_current_phase_s = rand(43, 60);
            $record2->primary_current_phase_t = rand(43, 60);
            $record2->secondary_current_phase_r = rand(1050, 1083);
            $record2->secondary_current_phase_s = rand(1050, 1083);
            $record2->secondary_current_phase_t = rand(1050, 1083);
            $record2->primary_voltage = rand(19500, 20000);
            $record2->secondary_voltage = rand(375, 400);
            $record2->cleanliness = array(0 => 'Clean', 1 => 'Dirty')[rand(0, 1)];
            $record2->oil_temperature = rand(3750, 6000) / 100;
            $record2->winding_temperature = rand(3750, 6000) / 100;
            $record2->noise = array(0 => 'Normal', 1 => 'Abnormal')[rand(0, 1)];
            $record2->silica_gel = array(0 => 'Good', 1 => 'Satisfactory', 2 => 'Unsatisfactory', 3 => 'Unacceptable')[rand(0, 1)];
            $record2->earthing_connection = array(0 => 'No loose', 1 => 'Loose')[rand(0, 1)];
            $record2->oil_leakage = array(0 => 'No leaks', 1 => 'Leaks')[rand(0, 1)];
            $record2->oil_level = rand(70, 88);
            $record2->blower_condition = array(0 => 'Good', 1 => 'Not good')[rand(0, 1)];
            $record2->department = $user->department;
            $record2->nik = $user->nik;
            $record2->created_at = Carbon::now()->addMonths(- ($year - $i));
            $record2->save();
        }
    }
}
