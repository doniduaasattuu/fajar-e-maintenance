<?php

namespace Database\Seeders;

use App\Models\Finding;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FindingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $finding1 = new Finding();
        $finding1->id = uniqid();
        $finding1->area = 'PM3';
        $finding1->description = 'Motor panas tertutup buburan';
        $finding1->image = $finding1->id . '.jpg';
        $finding1->status = 'Open';
        $finding1->equipment = 'MGM000481';
        $finding1->funcloc = 'FP-01-PM3-REL-PPRL-PRAR';
        $finding1->notification = null;
        $finding1->reporter = 'Doni Darmawan';
        $finding1->created_at = '2023-04-21 08:09:32';
        $finding1->updated_at = null;
        $finding1->save();

        $finding2 = new Finding();
        $finding2->id = uniqid();
        $finding2->area = 'PM3';
        $finding2->description = 'Cover kipas lepas';
        $finding2->image = $finding2->id . '.jpg';
        $finding2->status = 'Open';
        $finding2->equipment = 'MGM000481';
        $finding2->funcloc = 'FP-01-PM3-REL-PPRL-PRAR';
        $finding2->notification = null;
        $finding2->reporter = 'Doni Darmawan';
        $finding2->created_at = '2023-06-01 14:11:53';
        $finding2->updated_at = null;
        $finding2->save();
    }
}
