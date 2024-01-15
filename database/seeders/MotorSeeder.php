<?php

namespace Database\Seeders;

use App\Models\Motor;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $motor1 = new Motor();
        $motor1->id = "EMO000426";
        $motor1->status = "Installed";
        $motor1->funcloc = "FP-01-SP3-RJS-T092-P092";
        $motor1->sort_field = "SP3.P.70/M";
        $motor1->description = "AC MOTOR;380V,50Hz,75kW,4P,250M,B3";
        $motor1->material_number = "10010668";
        $motor1->unique_id = "1804";
        $motor1->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList1804";
        $motor1->created_at = Carbon::now()->toDateTimeString();
        $motor1->updated_at = Carbon::now()->toDateTimeString();
        $motor1->save();

        $motor2 = new Motor();
        $motor2->id = "MGM000481";
        $motor2->status = "Installed";
        $motor2->funcloc = "FP-01-PM3-REL-PPRL-PRAR";
        $motor2->sort_field = "PM3.REEL.PRAR/GM";
        $motor2->description = "GR.MOTOR;5.5kW,i=165,CHHM86195DBB165,CYC";
        $motor2->material_number = null;
        $motor2->unique_id = "2100";
        $motor2->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList2100";
        $motor2->created_at = Carbon::now()->toDateTimeString();
        $motor2->updated_at = Carbon::now()->toDateTimeString();
        $motor2->save();

        $motor3 = new Motor();
        $motor3->id = "EMO001056";
        $motor3->status = "Installed";
        $motor3->funcloc = "FP-01-CH3-ALM-T089-P085";
        $motor3->sort_field = "CH3.C06/M";
        $motor3->description = "AC MOTOR;380V,50Hz,3kW,4P,100L,B3";
        $motor3->material_number = null;
        $motor3->unique_id = "2008";
        $motor3->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList2008";
        $motor3->created_at = Carbon::now()->toDateTimeString();
        $motor3->updated_at = Carbon::now()->toDateTimeString();
        $motor3->save();

        $motor4 = new Motor();
        $motor4->id = "EMO004493";
        $motor4->status = "Installed";
        $motor4->funcloc = "FP-01-PM8-PRS-PRS2-MD05";
        $motor4->sort_field = "PM8/PRS-PRS2-MD05";
        $motor4->description = "MOTOR,AC,ICF-CHKM11 770A,750KW,6P,690V";
        $motor4->material_number = null;
        $motor4->unique_id = "3719";
        $motor4->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList3719";
        $motor4->created_at = Carbon::now()->toDateTimeString();
        $motor4->updated_at = Carbon::now()->toDateTimeString();
        $motor4->save();

        $motor5 = new Motor();
        $motor5->id = "EMO003604";
        $motor5->status = "Installed";
        $motor5->funcloc = "FP-01-SP1-MXW-RF04";
        $motor5->sort_field = "SP1.MXW.RF04.KNF/M";
        $motor5->description = "MOTOR,MASTER PB 1,5-2,2/3,5-5,1A,4P";
        $motor5->material_number = null;
        $motor5->unique_id = "188";
        $motor5->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList188";
        $motor5->created_at = Carbon::now()->toDateTimeString();
        $motor5->updated_at = Carbon::now()->toDateTimeString();
        $motor5->save();

        $motor6 = new Motor();
        $motor6->id = "EMO001092";
        $motor6->status = "Installed";
        $motor6->funcloc = "FP-01-SP5-OCC-FR01";
        $motor6->sort_field = "SP5.M-21/M";
        $motor6->description = "TECO,AEJE215HP,316A,315CC,8P,380V";
        $motor6->material_number = null;
        $motor6->unique_id = "2568";
        $motor6->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList2568";
        $motor6->created_at = Carbon::now()->toDateTimeString();
        $motor6->updated_at = Carbon::now()->toDateTimeString();
        $motor6->save();

        $motor7 = new Motor();
        $motor7->id = "EMO005614";
        $motor7->status = "Installed";
        $motor7->funcloc = "FP-01-PM7-VAS-VP13";
        $motor7->sort_field = "PM7.VAS/VP-18101000/M";
        $motor7->description = "AC MOTOR;690V,50Hz,1100kW,4P,400L,B3";
        $motor7->material_number = null;
        $motor7->unique_id = "4821";
        $motor7->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList4821";
        $motor7->created_at = Carbon::now()->toDateTimeString();
        $motor7->updated_at = Carbon::now()->toDateTimeString();
        $motor7->save();

        $motor8 = new Motor();
        $motor8->id = "EMO002281";
        $motor8->status = "Installed";
        $motor8->funcloc = "FP-01-IN1-BIF-STDM-P050";
        $motor8->sort_field = "BOILER CIRCULATING PUMP 1";
        $motor8->description = "IN1-BIF-STDM-P050/MBCP1/M-12A";
        $motor8->material_number = null;
        $motor8->unique_id = "5406";
        $motor8->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList5406";
        $motor8->created_at = Carbon::now()->toDateTimeString();
        $motor8->updated_at = Carbon::now()->toDateTimeString();
        $motor8->save();

        $motor9 = new Motor();
        $motor9->id = "EMO003963";
        $motor9->status = "Installed";
        $motor9->funcloc = "FP-01-SP1-UKP-RF07";
        $motor9->sort_field = "SP1.MW.DDR1/M";
        $motor9->description = "AC MOTOR;3000V,50Hz,335kW,10P,8307S,B3";
        $motor9->material_number = "10012013";
        $motor9->unique_id = "233";
        $motor9->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList233";
        $motor9->created_at = Carbon::now()->toDateTimeString();
        $motor9->updated_at = Carbon::now()->toDateTimeString();
        $motor9->save();

        $motor10 = new Motor();
        $motor10->id = "EMO009999";
        $motor10->status = "Available";
        $motor10->funcloc = null;
        $motor10->sort_field = null;
        $motor10->description = "MOTOR/AC/11kW/21.6A";
        $motor10->material_number = "10012013";
        $motor10->unique_id = "9999";
        $motor10->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList9999";
        $motor10->created_at = Carbon::now()->toDateTimeString();
        $motor10->updated_at = Carbon::now()->toDateTimeString();
        $motor10->save();

        $motor10 = new Motor();
        $motor10->id = "EMO001234";
        $motor10->status = "Repaired";
        $motor10->funcloc = null;
        $motor10->sort_field = null;
        $motor10->description = "MOTOR/AC/37kW/52A";
        $motor10->material_number = null;
        $motor10->unique_id = "1234";
        $motor10->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList1234";
        $motor10->created_at = Carbon::now()->toDateTimeString();
        $motor10->updated_at = Carbon::now()->toDateTimeString();
        $motor10->save();

        $motor12 = new Motor();
        $motor12->id = "EMO001402";
        $motor12->status = "Installed";
        $motor12->funcloc = "FP-01-CH5-ALM-T098-P121";
        $motor12->sort_field = "5AL-PC-01/M";
        $motor12->description = "AC MOTOR;380V,50Hz,4kW,4P,112M,B3";
        $motor12->material_number = null;
        $motor12->unique_id = "2850";
        $motor12->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList2850";
        $motor12->created_at = Carbon::now()->toDateTimeString();
        $motor12->updated_at = Carbon::now()->toDateTimeString();
        $motor12->save();

        $motor13 = new Motor();
        $motor13->id = "EMO000008";
        $motor13->status = "Available";
        $motor13->funcloc = null;
        $motor13->sort_field = null;
        $motor13->description = "AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3";
        $motor13->material_number = "10010591";
        $motor13->unique_id = "4592";
        $motor13->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList4592";
        $motor13->created_at = Carbon::now()->toDateTimeString();
        $motor13->updated_at = Carbon::now()->toDateTimeString();
        $motor13->save();

        $motor14 = new Motor();
        $motor14->id = "EMO000023";
        $motor14->status = "Available";
        $motor14->funcloc = null;
        $motor14->sort_field = null;
        $motor14->description = "AC MOTOR;380V,50Hz,2.2kW,6P,112M";
        $motor14->material_number = "10010507";
        $motor14->unique_id = "5453";
        $motor14->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList5453";
        $motor14->created_at = Carbon::now()->toDateTimeString();
        $motor14->updated_at = Carbon::now()->toDateTimeString();
        $motor14->save();

        $motor15 = new Motor();
        $motor15->id = "EMO000042";
        $motor15->status = "Available";
        $motor15->funcloc = null;
        $motor15->sort_field = null;
        $motor15->description = "AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3";
        $motor15->material_number = "10010692";
        $motor15->unique_id = "580";
        $motor15->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList580";
        $motor15->created_at = Carbon::now()->toDateTimeString();
        $motor15->updated_at = Carbon::now()->toDateTimeString();
        $motor15->save();

        $motor16 = new Motor();
        $motor16->id = "EMO000075";
        $motor16->status = "Available";
        $motor16->funcloc = null;
        $motor16->sort_field = null;
        $motor16->description = "AC MOTOR;380V,50Hz,11kW,4P,160M,B3";
        $motor16->material_number = "10011051";
        $motor16->unique_id = "273";
        $motor16->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList273";
        $motor16->created_at = Carbon::now()->toDateTimeString();
        $motor16->updated_at = Carbon::now()->toDateTimeString();
        $motor16->save();

        $motor17 = new Motor();
        $motor17->id = "EMO000094";
        $motor17->status = "Available";
        $motor17->funcloc = null;
        $motor17->sort_field = null;
        $motor17->description = "AC MOTOR;380V,50Hz,22kW,4P,180L,B3";
        $motor17->material_number = "10020913";
        $motor17->unique_id = "155";
        $motor17->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList155";
        $motor17->created_at = Carbon::now()->toDateTimeString();
        $motor17->updated_at = Carbon::now()->toDateTimeString();
        $motor17->save();

        $motor18 = new Motor();
        $motor18->id = "EMO000153";
        $motor18->status = "Available";
        $motor18->funcloc = null;
        $motor18->sort_field = null;
        $motor18->description = "AC MOTOR;380V,50Hz,15kW,4P,160L,B5";
        $motor18->material_number = "10011100";
        $motor18->unique_id = "382";
        $motor18->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList382";
        $motor18->created_at = Carbon::now()->toDateTimeString();
        $motor18->updated_at = Carbon::now()->toDateTimeString();
        $motor18->save();

        $motor19 = new Motor();
        $motor19->id = "EMO000105";
        $motor19->status = "Repaired";
        $motor19->funcloc = null;
        $motor19->sort_field = null;
        $motor19->description = "AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3";
        $motor19->material_number = "10010923";
        $motor19->unique_id = "56";
        $motor19->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList56";
        $motor19->created_at = Carbon::now()->toDateTimeString();
        $motor19->updated_at = Carbon::now()->toDateTimeString();
        $motor19->save();

        $motor20 = new Motor();
        $motor20->id = "EMO000112";
        $motor20->status = "Repaired";
        $motor20->funcloc = null;
        $motor20->sort_field = null;
        $motor20->description = "AC MOTOR;380V,50Hz,15kW,4P,160L,B3";
        $motor20->material_number = "10010924";
        $motor20->unique_id = "287";
        $motor20->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList287";
        $motor20->created_at = Carbon::now()->toDateTimeString();
        $motor20->updated_at = Carbon::now()->toDateTimeString();
        $motor20->save();

        $motor21 = new Motor();
        $motor21->id = "EMO000113";
        $motor21->status = "Repaired";
        $motor21->funcloc = null;
        $motor21->sort_field = null;
        $motor21->description = "AC MOTOR;380V,50Hz,90kW,6P,315S,B3";
        $motor21->material_number = "10025942";
        $motor21->unique_id = "293";
        $motor21->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList293";
        $motor21->created_at = Carbon::now()->toDateTimeString();
        $motor21->updated_at = Carbon::now()->toDateTimeString();
        $motor21->save();

        $motor21 = new Motor();
        $motor21->id = "EMO000124";
        $motor21->status = "Repaired";
        $motor21->funcloc = null;
        $motor21->sort_field = null;
        $motor21->description = "AC MOTOR;3000V,50Hz,250kW,8P,400B,B3";
        $motor21->material_number = "10010982";
        $motor21->unique_id = "358";
        $motor21->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList358";
        $motor21->created_at = Carbon::now()->toDateTimeString();
        $motor21->updated_at = Carbon::now()->toDateTimeString();
        $motor21->save();
    }
}
