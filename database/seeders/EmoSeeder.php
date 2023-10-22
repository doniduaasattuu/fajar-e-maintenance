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
        $emo->funcloc = "FP-01-SP3-RJS-T092-P092";
        $emo->material_number = "10010668";
        $emo->equipment_description = "AC MOTOR;380V,50Hz,75kW,4P,250M,B3";
        $emo->status = "Installed";
        $emo->sort_field = "SP3.P.70/M";
        $emo->unique_id = "1804";
        $emo->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList1804";
        $emo->created_at = Carbon::now()->toDateTimeString();
        $emo->updated_at = Carbon::now()->toDateTimeString();
        $emo->save();

        $emo1 = new Emo();
        $emo1->id = "MGM000481";
        $emo1->funcloc = "FP-01-PM3-REL-PPRL-PRAR";
        $emo1->equipment_description = "GR.MOTOR;5.5kW,i=165,CHHM86195DBB165,CYC";
        $emo1->status = "Installed";
        $emo1->sort_field = "PM3.REEL.PRAR/GM";
        $emo1->unique_id = "2100";
        $emo1->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList2100";
        $emo1->created_at = Carbon::now()->toDateTimeString();
        $emo1->updated_at = Carbon::now()->toDateTimeString();
        $emo1->save();
    }
}
