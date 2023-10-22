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
    }
}
