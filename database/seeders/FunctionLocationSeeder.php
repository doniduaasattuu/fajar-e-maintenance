<?php

namespace Database\Seeders;

use App\Models\FunctionLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class FunctionLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $funloc = new FunctionLocation();
        $funloc->id = "FP-01-SP3-RJS-T092-P092";
        $funloc->tag_name = "Pompa P-70";
        $funloc->created_at = Carbon::now()->toDateTimeString();
        $funloc->updated_at = Carbon::now()->toDateTimeString();
        $funloc->save();

        $funloc1 = new FunctionLocation();
        $funloc1->id = "FP-01-PM3-REL-PPRL-PRAR";
        $funloc1->tag_name = "PM3.REEL.PRAR/GM";
        $funloc1->created_at = Carbon::now()->toDateTimeString();
        $funloc1->updated_at = Carbon::now()->toDateTimeString();
        $funloc1->save();

        $funloc2 = new FunctionLocation();
        $funloc2->id = "FP-01-CH3-ALM-T089-P085";
        $funloc2->tag_name = "CH3.C06/M";
        $funloc2->created_at = Carbon::now()->toDateTimeString();
        $funloc2->updated_at = Carbon::now()->toDateTimeString();
        $funloc2->save();

        $funloc3 = new FunctionLocation();
        $funloc3->id = "FP-01-PM8-PRS-PRS2-MD05";
        $funloc3->tag_name = "PM8/PRS-PRS2-MD05";
        $funloc3->created_at = Carbon::now()->toDateTimeString();
        $funloc3->updated_at = Carbon::now()->toDateTimeString();
        $funloc3->save();

        $funloc4 = new FunctionLocation();
        $funloc4->id = "FP-01-SP1-UKP-RF07";
        $funloc4->tag_name = "SP1.MW.DDR1/M";
        $funloc4->created_at = Carbon::now()->toDateTimeString();
        $funloc4->updated_at = Carbon::now()->toDateTimeString();
        $funloc4->save();

        $funloc5 = new FunctionLocation();
        $funloc5->id = "FP-01-SP1-MXW-RF04";
        $funloc5->tag_name = "SP1.UK.DDR3/M";
        $funloc5->created_at = Carbon::now()->toDateTimeString();
        $funloc5->updated_at = Carbon::now()->toDateTimeString();
        $funloc5->save();

        $funloc6 = new FunctionLocation();
        $funloc6->id = "FP-01-SP5-OCC-FR01";
        $funloc6->tag_name = "SP5.M-21/M";
        $funloc6->created_at = Carbon::now()->toDateTimeString();
        $funloc6->updated_at = Carbon::now()->toDateTimeString();
        $funloc6->save();

        $funloc7 = new FunctionLocation();
        $funloc7->id = "FP-01-PM7-VAS-VP13";
        $funloc7->tag_name = "PM7.VAS/VP-18101000/M";
        $funloc7->created_at = Carbon::now()->toDateTimeString();
        $funloc7->updated_at = Carbon::now()->toDateTimeString();
        $funloc7->save();

        $funloc8 = new FunctionLocation();
        $funloc8->id = "FP-01-IN1-BIF-STDM-P050";
        $funloc8->tag_name = "IN1-BIF-STDM-P050/MBCP1/M-12A";
        $funloc8->created_at = Carbon::now()->toDateTimeString();
        $funloc8->updated_at = Carbon::now()->toDateTimeString();
        $funloc8->save();
    }
}
