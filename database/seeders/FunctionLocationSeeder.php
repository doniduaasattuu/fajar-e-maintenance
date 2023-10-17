<?php

namespace Database\Seeders;

use App\Models\FunctionLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FunctionLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $funloc = new FunctionLocation();
        $funloc->id = "FP-01-SP3-RJS-T092-P092";
        $funloc->emo = "EMO000426";
        $funloc->tag_name = "Pompa P-70";
        $funloc->save();
    }
}
