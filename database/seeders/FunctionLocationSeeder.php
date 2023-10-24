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
    }
}
