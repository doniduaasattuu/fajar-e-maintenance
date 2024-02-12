<?php

namespace Database\Seeders;

use App\Models\Trafo;
use App\Models\TrafoRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrafoRecordSeederAll extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('trafo_records')->delete();

        $trafos = Trafo::query()->get();

        foreach ($trafos as $trafo) {

            $year = 36;
            $users = User::all();

            for ($i = 0; $i < $year; $i++) {

                $record_trafo = new TrafoRecord();
                $record_trafo->id = uniqid();
                $record_trafo->funcloc = $trafo->funcloc ?? 'FP-01-PM3';
                $record_trafo->trafo = $trafo->id;
                $record_trafo->sort_field = $trafo->sort_field ?? 'TRAFO';
                $record_trafo->trafo_status = array(0 => "Online", 1 => "Offline")[rand(0, 1)];
                $record_trafo->primary_current_phase_r = rand(43, 60);
                $record_trafo->primary_current_phase_s = rand(43, 60);
                $record_trafo->primary_current_phase_t = rand(43, 60);
                $record_trafo->secondary_current_phase_r = rand(1050, 1083);
                $record_trafo->secondary_current_phase_s = rand(1050, 1083);
                $record_trafo->secondary_current_phase_t = rand(1050, 1083);
                $record_trafo->primary_voltage = rand(19500, 20000);
                $record_trafo->secondary_voltage = rand(375, 400);
                $record_trafo->cleanliness = array(0 => 'Clean', 1 => 'Dirty')[rand(0, 1)];
                $record_trafo->oil_temperature = rand(3750, 6000) / 100;
                $record_trafo->winding_temperature = rand(3750, 6000) / 100;
                $record_trafo->noise = array(0 => 'Normal', 1 => 'Abnormal')[rand(0, 1)];
                $record_trafo->silica_gel = array(0 => 'Dark blue', 1 => 'Light blue', 2 => 'Pink', 3 => 'Brown')[rand(0, 1)];
                $record_trafo->earthing_connection = array(0 => 'No loose', 1 => 'Loose')[rand(0, 1)];
                $record_trafo->oil_leakage = array(0 => 'No leaks', 1 => 'Leaks')[rand(0, 1)];
                $record_trafo->oil_level = rand(70, 88);
                $record_trafo->blower_condition = array(0 => 'Good', 1 => 'Not good')[rand(0, 1)];
                $record_trafo->nik = $users[rand(0, sizeof($users) - 1)]->nik;
                $record_trafo->created_at = Carbon::now()->addMonths(- ($year - $i));
                $record_trafo->save();
            }
        }
    }
}
