<?php

namespace Database\Seeders;

use App\Models\TransformerRecord;
use App\Models\Transformers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransformerRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table("transformer_records")->truncate();

        // $nik = User::query()->find("55000135")->nik;
        $users = User::query()->get();
        $transformer = Transformers::query()->find("ETF000085");

        $year = 36;

        for ($i = 0; $i < $year; $i++) {

            $transformer_record = new TransformerRecord();
            $transformer_record->funcloc = $transformer->funcloc;
            $transformer_record->transformer = $transformer->id;
            $transformer_record->sort_field = $transformer->sort_field;
            $transformer_record->transformer_status = array(0 => "Online", 1 => "Offline")[rand(0, 1)];
            $transformer_record->primary_current_phase_r = rand(160, 165);
            $transformer_record->primary_current_phase_s = rand(160, 165);
            $transformer_record->primary_current_phase_t = rand(160, 165);
            $transformer_record->secondary_current_phase_r = rand(1056, 1226);
            $transformer_record->secondary_current_phase_s = rand(1056, 1226);
            $transformer_record->secondary_current_phase_t = rand(1056, 1226);
            $transformer_record->primary_voltage = rand(148213, 150000);
            $transformer_record->secondary_voltage = rand(19425, 20000);
            $transformer_record->oil_temperature = rand(35, 101);
            $transformer_record->winding_temperature = rand(35, 101);
            $transformer_record->clean_status = array(0 => "Clean", 1 => "Dirty")[rand(0, 1)];
            $transformer_record->noise = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
            $transformer_record->silica_gel = array(0 => "Dark Blue", 1 => "Light Blue", 2 => "Pink", 3 => "Brown")[rand(0, 3)];
            $transformer_record->earthing_connection = array(0 => "Tight", 1 => "Loose")[rand(0, 1)];
            $transformer_record->oil_leakage = array(0 => "No Leaks", 1 => "Leaks")[rand(0, 1)];
            $transformer_record->blower_condition = array(0 => "Normal", 1 => "Abnormal")[rand(0, 1)];
            $transformer_record->comment = null;
            $transformer_record->created_at = Carbon::now()->addMonths(- ($year - $i));
            $transformer_record->nik = $users[rand(0, sizeof($users) - 1)]->nik;
            $transformer_record->save();
        }
    }
}
