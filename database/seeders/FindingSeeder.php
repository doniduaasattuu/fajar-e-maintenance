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
        $finding1->department = 'EI2';
        $finding1->status = 'Open';
        $finding1->equipment = 'MGM000481';
        $finding1->funcloc = 'FP-01-PM3-REL-PPRL-PRAR';
        $finding1->notification = '80012235';
        $finding1->description = 'Motor panas tertutup buburan';
        $finding1->image = "$id.jpg";
        $finding1->reporter = 'Doni Darmawan';
        $finding1->created_at = '2023-04-21 08:09:32';
        $finding1->updated_at = null;
        $finding1->save();

        $finding2 = new Finding();
        $finding2->id = uniqid();
        $finding2->area = 'PM3';
        $finding2->department = 'EI2';
        $finding2->status = 'Open';
        $finding2->equipment = 'MGM000481';
        $finding2->funcloc = 'FP-01-PM3-REL-PPRL-PRAR';
        $finding2->notification = null;
        $finding2->description = 'Cover kipas lepas';
        $finding2->image = null;
        $finding2->reporter = 'Doni Darmawan';
        $finding2->created_at = '2023-06-01 14:11:53';
        $finding2->updated_at = null;
        $finding2->save();

        $finding3 = new Finding();
        $finding3->id = uniqid();
        $finding3->area = 'PM7';
        $finding3->department = 'EI2';
        $finding3->status = 'Open';
        $finding3->equipment = 'EMO005614';
        $finding3->funcloc = 'FP-01-PM7-VAS-VP13';
        $finding3->notification = null;
        $finding3->description = 'Inner bearing defect motor refiner PM7';
        $finding3->image = null;
        $finding3->reporter = 'Doni Darmawan';
        $finding3->created_at = '2024-01-11 14:11:53';
        $finding3->updated_at = null;
        $finding3->save();

        $finding4 = new Finding();
        $finding4->id = uniqid();
        $finding4->area = 'IN1';
        $finding4->department = 'EI2';
        $finding4->status = 'Closed';
        $finding4->equipment = 'ETF000085';
        $finding4->funcloc = 'FP-01-IN1';
        $finding4->notification = null;
        $finding4->description = 'Noise trafo PLN';
        $finding4->image = null;
        $finding4->reporter = 'Doni Darmawan';
        $finding4->created_at = '2024-01-01 14:11:53';
        $finding4->updated_at = null;
        $finding4->save();

        $finding5 = new Finding();
        $finding5->id = uniqid();
        $finding5->area = 'ENC';
        $finding5->department = 'EI2';
        $finding5->status = 'Closed';
        $finding5->equipment = 'ETF000006';
        $finding5->funcloc = 'FP-01-ENC';
        $finding5->notification = null;
        $finding5->description = 'Drop primary voltage 5%';
        $finding5->image = null;
        $finding5->reporter = 'Suryanto';
        $finding5->created_at = '2023-03-01 14:11:53';
        $finding5->updated_at = null;
        $finding5->save();

        $finding6 = new Finding();
        $finding6->id = uniqid();
        $finding6->area = 'PM3';
        $finding6->department = 'EI2';
        $finding6->status = 'Open';
        $finding6->equipment = 'EMO000656';
        $finding6->funcloc = 'FP-01-PM3';
        $finding6->notification = null;
        $finding6->description = 'Motor noise bearing NDE';
        $finding6->image = null;
        $finding6->reporter = 'Edi Supriadi';
        $finding6->created_at = '2023-01-01 14:11:53';
        $finding6->updated_at = null;
        $finding6->save();

        $finding7 = new Finding();
        $finding7->id = uniqid();
        $finding7->area = 'PM3';
        $finding7->department = 'EI3';
        $finding7->status = 'Closed';
        $finding7->equipment = null;
        $finding7->funcloc = null;
        $finding7->notification = null;
        $finding7->description = 'Area licin oli lubrikasi tumpah';
        $finding7->image = null;
        $finding7->reporter = 'Edi Supriadi';
        $finding7->created_at = '2023-01-01 14:11:53';
        $finding7->updated_at = null;
        $finding7->save();
    }
}
