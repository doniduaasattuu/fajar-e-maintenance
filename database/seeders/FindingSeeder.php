<?php

namespace Database\Seeders;

use App\Models\Finding;
use App\Services\FindingService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class FindingSeeder extends Seeder
{
    private FindingService $findingService;

    public function __construct(FindingService $findingService)
    {
        $this->findingService = $findingService;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id = uniqid();
        $image = UploadedFile::fake()->image("$id.jpg");
        $this->findingService->saveImage($image, $id);

        $finding1 = new Finding();
        $finding1->id = $id;
        $finding1->area = 'PM3';
        $finding1->description = 'Motor panas tertutup buburan';
        $finding1->image = "$id.jpg";
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
        $finding2->image = null;
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
