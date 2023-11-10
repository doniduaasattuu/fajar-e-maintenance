<?php

namespace Database\Seeders;

use App\Models\EmoRecord;
use App\Models\Emo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmoRecordSeederAll extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emos = Emo::query()->select(["id", "funcloc"])->get();
        $fullname = User::query()->find("55000154")->fullname;

        DB::table("emo_records")->truncate();

        foreach ($emos as $emo_item) {
            $year = 30;
            for ($i = 0; $i < $year; $i++) {
                $emo_record = new EmoRecord();
                $emo_record->funcloc = $emo_item->funcloc;
                $emo_record->emo = $emo_item->id;
                $emo_record->clean_status = "Clean";
                $emo_record->nipple_grease = "Available";
                $emo_record->number_of_greasing = rand(0, 8) * 10;
                if ($i == 21 || $i == 24) {
                    $emo_record->motor_status = "Not Running";

                    $emo_record->temperature_a = 0;
                    $emo_record->temperature_b = 0;
                    $emo_record->temperature_c = 0;
                    $emo_record->temperature_d = 0;

                    $emo_record->vibration_value_de = 0;
                    $emo_record->vibration_de = null;
                    $emo_record->vibration_value_nde = 0;
                    $emo_record->vibration_nde = null;
                } else {
                    $emo_record->motor_status = "Running";

                    $emo_record->temperature_a = rand(35, 80);
                    $emo_record->temperature_b = rand(35, 80);
                    $emo_record->temperature_c = rand(35, 80);
                    $emo_record->temperature_d = rand(35, 80);

                    $emo_record->vibration_value_de = rand(0, 112) / 100;
                    $emo_record->vibration_de = "Good";
                    $emo_record->vibration_value_nde = rand(0, 112) / 100;
                    $emo_record->vibration_nde = "Good";
                }
                $emo_record->created_at = Carbon::now()->addMonths(- ($year - $i));
                $emo_record->checked_by = $fullname;
                $emo_record->save();
            }
        }
    }
}
