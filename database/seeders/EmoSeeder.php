<?php

namespace Database\Seeders;

use App\Models\Emo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emo = new Emo();
        $emo->id = "EMO000426";
        $emo->material_number = "10010668";
        $emo->equipment_description = "AC MOTOR;380V,50Hz,75kW,4P,250M,B3";
        $emo->status = "Installed";
        $emo->sort_field = "SP3.P.70/M";
        $emo->unique_id = "1804";
        $emo->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList1804";
        $emo->created_at = Carbon::now();
        $emo->updated_at = Carbon::now();
        $emo->save();
    }
}
