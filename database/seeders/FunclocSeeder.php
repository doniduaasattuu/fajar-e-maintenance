<?php

namespace Database\Seeders;

use App\Models\Funcloc;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FunclocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $funloc1 = new Funcloc();
        $funloc1->id = "FP-01-SP3-RJS-T092-P092";
        $funloc1->description = "PM3.SUM.P70";
        $funloc1->created_at = Carbon::now()->toDateTimeString();
        $funloc1->save();

        $funloc2 = new Funcloc();
        $funloc2->id = "FP-01-PM3-REL-PPRL-PRAR";
        $funloc2->description = "PM3.REEL.PRAR/GM";
        $funloc2->created_at = Carbon::now()->toDateTimeString();
        $funloc2->save();

        $funloc3 = new Funcloc();
        $funloc3->id = "FP-01-CH3-ALM-T089-P085";
        $funloc3->description = "CH3.C06/M";
        $funloc3->created_at = Carbon::now()->toDateTimeString();
        $funloc3->save();

        $funloc4 = new Funcloc();
        $funloc4->id = "FP-01-PM8-PRS-PRS2-MD05";
        $funloc4->description = "PM8/PRS-PRS2-MD05";
        $funloc4->created_at = Carbon::now()->toDateTimeString();
        $funloc4->save();

        $funloc5 = new Funcloc();
        $funloc5->id = "FP-01-SP1-UKP-RF07";
        $funloc5->description = "SP1.MW.DDR1/M";
        $funloc5->created_at = Carbon::now()->toDateTimeString();
        $funloc5->save();

        $funloc6 = new Funcloc();
        $funloc6->id = "FP-01-SP1-MXW-RF04";
        $funloc6->description = "SP1.UK.DDR3/M";
        $funloc6->created_at = Carbon::now()->toDateTimeString();
        $funloc6->save();

        $funloc7 = new Funcloc();
        $funloc7->id = "FP-01-SP5-OCC-FR01";
        $funloc7->description = "SP5.M-21/M";
        $funloc7->created_at = Carbon::now()->toDateTimeString();
        $funloc7->save();

        $funloc8 = new Funcloc();
        $funloc8->id = "FP-01-PM7-VAS-VP13";
        $funloc8->description = "PM7.VAS/VP-18101000/M";
        $funloc8->created_at = Carbon::now()->toDateTimeString();
        $funloc8->save();

        $funloc9 = new Funcloc();
        $funloc9->id = "FP-01-IN1-BIF-STDM-P050";
        $funloc9->description = "IN1-BIF-STDM-P050/MBCP1/M-12A";
        $funloc9->created_at = Carbon::now()->toDateTimeString();
        $funloc9->save();

        $funcloc10 = new Funcloc();
        $funcloc10->id = "FP-01-IN1";
        $funcloc10->description = "TRAFO ENC";
        $funcloc10->created_at = Carbon::now()->toDateTimeString();
        $funcloc10->save();

        $funcloc11 = new Funcloc();
        $funcloc11->id = "FP-01-GT2-TRF-PWP2";
        $funcloc11->description = "TR AUX GTG #1";
        $funcloc11->created_at = Carbon::now()->toDateTimeString();
        $funcloc11->save();

        $funcloc12 = new Funcloc();
        $funcloc12->id = "FP-01-BO3-CAS-COM2";
        $funcloc12->description = "BO3.CAS.COM2/M";
        $funcloc12->created_at = Carbon::now()->toDateTimeString();
        $funcloc12->save();

        $funcloc13 = new Funcloc();
        $funcloc13->id = "FP-01-CH5-ALM-T098-P121";
        $funcloc13->description = "5AL-PC-01/M";
        $funcloc13->created_at = Carbon::now()->toDateTimeString();
        $funcloc13->save();

        // TRAFO
        $funcloc15 = new Funcloc();
        $funcloc15->id = "FP-01-ENC-TRF-PLN1";
        $funcloc15->description = "Trafo";
        $funcloc15->created_at = Carbon::now()->toDateTimeString();
        $funcloc15->save();

        $funcloc17 = new Funcloc();
        $funcloc17->id = "FP-01-GT1-TRF-PWP1";
        $funcloc17->description = "Trafo";
        $funcloc17->created_at = Carbon::now()->toDateTimeString();
        $funcloc17->save();

        $funcloc18 = new Funcloc();
        $funcloc18->id = "FP-01-GT1";
        $funcloc18->description = "Trafo";
        $funcloc18->created_at = Carbon::now()->toDateTimeString();
        $funcloc18->save();

        $funcloc19 = new Funcloc();
        $funcloc19->id = "FP-01-GT2-TRF-UTY2";
        $funcloc19->description = "Trafo";
        $funcloc19->created_at = Carbon::now()->toDateTimeString();
        $funcloc19->save();

        $funcloc20 = new Funcloc();
        $funcloc20->id = "FP-01-GT1-TRF-UTY1";
        $funcloc20->description = "Trafo";
        $funcloc20->created_at = Carbon::now()->toDateTimeString();
        $funcloc20->save();

        $funcloc21 = new Funcloc();
        $funcloc21->id = "FP-01-IN1-TRF";
        $funcloc21->description = "Trafo";
        $funcloc21->created_at = Carbon::now()->toDateTimeString();
        $funcloc21->save();
    }
}
