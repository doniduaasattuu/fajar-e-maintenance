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

        $emo2 = new Emo();
        $emo2->id = "EMO001056";
        $emo2->funcloc = "FP-01-CH3-ALM-T089-P085";
        $emo2->equipment_description = "AC MOTOR;380V,50Hz,3kW,4P,100L,B3";
        $emo2->status = "Installed";
        $emo2->sort_field = "CH3.C06/M";
        $emo2->unique_id = "2008";
        $emo2->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList2008";
        $emo2->created_at = Carbon::now()->toDateTimeString();
        $emo2->updated_at = Carbon::now()->toDateTimeString();
        $emo2->save();

        $emo3 = new Emo();
        $emo3->id = "EMO004493";
        $emo3->funcloc = "FP-01-PM8-PRS-PRS2-MD05";
        $emo3->equipment_description = "MOTOR,AC,ICF-CHKM11 770A,750KW,6P,690V";
        $emo3->status = "Installed";
        $emo3->sort_field = "PM8/PRS-PRS2-MD05";
        $emo3->unique_id = "3719";
        $emo3->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList3719";
        $emo3->created_at = Carbon::now()->toDateTimeString();
        $emo3->updated_at = Carbon::now()->toDateTimeString();
        $emo3->save();

        $emo4 = new Emo();
        $emo4->id = "EMO003963";
        $emo4->funcloc = "FP-01-SP1-UKP-RF07";
        $emo4->equipment_description = "AC MOTOR;3000V,50Hz,335kW,10P,8307S,B3";
        $emo4->status = "Installed";
        $emo4->sort_field = "SP1.MW.DDR1/M";
        $emo4->unique_id = "233";
        $emo4->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList233";
        $emo4->created_at = Carbon::now()->toDateTimeString();
        $emo4->updated_at = Carbon::now()->toDateTimeString();
        $emo4->save();

        $emo5 = new Emo();
        $emo5->id = "EMO003604";
        $emo5->funcloc = "FP-01-SP1-MXW-RF04";
        $emo5->equipment_description = "MOTOR,MASTER PB 1,5-2,2/3,5-5,1A,4P";
        $emo5->status = "Installed";
        $emo5->sort_field = "SP1.MXW.RF04.KNF/M";
        $emo5->unique_id = "188";
        $emo5->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList188";
        $emo5->created_at = Carbon::now()->toDateTimeString();
        $emo5->updated_at = Carbon::now()->toDateTimeString();
        $emo5->save();

        $emo6 = new Emo();
        $emo6->id = "EMO001092";
        $emo6->funcloc = "FP-01-SP5-OCC-FR01";
        $emo6->equipment_description = "TECO,AEJE215HP,316A,315CC,8P,380V";
        $emo6->status = "Installed";
        $emo6->sort_field = "SP5.M-21/M";
        $emo6->unique_id = "2568";
        $emo6->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList2568";
        $emo6->created_at = Carbon::now()->toDateTimeString();
        $emo6->updated_at = Carbon::now()->toDateTimeString();
        $emo6->save();
    }
}
