<?php

namespace Database\Seeders;

use App\Models\Trafo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrafoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trafo1 = new Trafo();
        $trafo1->id = 'ETF000085';
        $trafo1->status = 'Installed';
        $trafo1->funcloc = 'FP-01-IN1';
        $trafo1->sort_field = 'TRAFO PLN';
        $trafo1->description = 'TRAFO;STEP DOWN;150/20kV;UNINDO 50 KVA;';
        $trafo1->material_number = null;
        $trafo1->unique_id = '1';
        $trafo1->qr_code_link = 'id=Fajar-TrafoList1';
        $trafo1->created_at = Carbon::now()->toDateTimeString();
        $trafo1->updated_at = Carbon::now()->toDateTimeString();
        $trafo1->save();

        $trafo2 = new Trafo();
        $trafo2->id = 'ETF000027';
        $trafo2->status = 'Installed';
        $trafo2->funcloc = 'FP-01-ENC-TRF-PLN1';
        $trafo2->sort_field = 'TR GTG #1';
        $trafo2->description = 'TR GTG #1';
        $trafo2->material_number = null;
        $trafo2->unique_id = '2';
        $trafo2->qr_code_link = 'id=Fajar-TrafoList2';
        $trafo2->created_at = Carbon::now()->toDateTimeString();
        $trafo2->updated_at = Carbon::now()->toDateTimeString();
        $trafo2->save();

        $trafo3 = new Trafo();
        $trafo3->id = 'ETF000060';
        $trafo3->status = 'Installed';
        $trafo3->funcloc = 'FP-01-GT1-TRF-PWP1';
        $trafo3->sort_field = 'TR GTG #2';
        $trafo3->description = 'TR GTG #2';
        $trafo3->material_number = null;
        $trafo3->unique_id = '3';
        $trafo3->qr_code_link = 'id=Fajar-TrafoList3';
        $trafo3->created_at = Carbon::now()->toDateTimeString();
        $trafo3->updated_at = Carbon::now()->toDateTimeString();
        $trafo3->save();

        $trafo4 = new Trafo();
        $trafo4->id = 'ETF000026';
        $trafo4->status = 'Installed';
        $trafo4->funcloc = 'FP-01-GT2-TRF-PWP2';
        $trafo4->sort_field = 'TR AUX GTG #1 lama';
        $trafo4->description = 'TR AUX GTG #1 lama';
        $trafo4->material_number = null;
        $trafo4->unique_id = '4';
        $trafo4->qr_code_link = 'id=Fajar-TrafoList4';
        $trafo4->created_at = Carbon::now()->toDateTimeString();
        $trafo4->updated_at = Carbon::now()->toDateTimeString();
        $trafo4->save();

        $trafo5 = new Trafo();
        $trafo5->id = 'ETF000059';
        $trafo5->status = 'Installed';
        $trafo5->funcloc = 'FP-01-GT1';
        $trafo5->sort_field = 'TR AUX GTG #2';
        $trafo5->description = 'TR AUX GTG #2';
        $trafo5->material_number = null;
        $trafo5->unique_id = '5';
        $trafo5->qr_code_link = 'id=Fajar-TrafoList5';
        $trafo5->created_at = Carbon::now()->toDateTimeString();
        $trafo5->updated_at = Carbon::now()->toDateTimeString();
        $trafo5->save();

        $trafo6 = new Trafo();
        $trafo6->id = 'ETF000120';
        $trafo6->status = 'Installed';
        $trafo6->funcloc = 'FP-01-GT2-TRF-UTY2';
        $trafo6->sort_field = 'TR AUX GTG #1 Baru';
        $trafo6->description = 'TR AUX GTG #1 Baru';
        $trafo6->material_number = null;
        $trafo6->unique_id = '6';
        $trafo6->qr_code_link = 'id=Fajar-TrafoList6';
        $trafo6->created_at = Carbon::now()->toDateTimeString();
        $trafo6->updated_at = Carbon::now()->toDateTimeString();
        $trafo6->save();

        $trafo7 = new Trafo();
        $trafo7->id = 'ETF000123';
        $trafo7->status = 'Installed';
        $trafo7->funcloc = 'FP-01-GT1-TRF-UTY1';
        $trafo7->sort_field = 'TR INCHENERATOR#1';
        $trafo7->description = 'TR INCHENERATOR#1';
        $trafo7->material_number = null;
        $trafo7->unique_id = '7';
        $trafo7->qr_code_link = 'id=Fajar-TrafoList7';
        $trafo7->created_at = Carbon::now()->toDateTimeString();
        $trafo7->updated_at = Carbon::now()->toDateTimeString();
        $trafo7->save();

        $trafo8 = new Trafo();
        $trafo8->id = 'ETF000006';
        $trafo8->status = 'Installed';
        $trafo8->funcloc = 'FP-01-IN1-TRF';
        $trafo8->sort_field = 'TR INCHENERATOR#2';
        $trafo8->description = 'TR INCHENERATOR#2';
        $trafo8->material_number = null;
        $trafo8->unique_id = '8';
        $trafo8->qr_code_link = 'id=Fajar-TrafoList8';
        $trafo8->created_at = Carbon::now()->toDateTimeString();
        $trafo8->updated_at = Carbon::now()->toDateTimeString();
        $trafo8->save();

        $trafo9 = new Trafo();
        $trafo9->id = 'ETF000032';
        $trafo9->status = 'Installed';
        $trafo9->funcloc = 'FP-01-IN1-TRF';
        $trafo9->sort_field = 'TR WWT';
        $trafo9->description = 'TR WWT';
        $trafo9->material_number = null;
        $trafo9->unique_id = '9';
        $trafo9->qr_code_link = 'id=Fajar-TrafoList9';
        $trafo9->created_at = Carbon::now()->toDateTimeString();
        $trafo9->updated_at = Carbon::now()->toDateTimeString();
        $trafo9->save();

        $trafo10 = new Trafo();
        $trafo10->id = 'ETF000091';
        $trafo10->status = 'Installed';
        $trafo10->funcloc = 'FP-01-IN1';
        $trafo10->sort_field = 'TRAFO ESP BOILER 3 NO.1';
        $trafo10->description = 'TRAFO ESP BOILER 3 NO.1';
        $trafo10->material_number = null;
        $trafo10->unique_id = '10';
        $trafo10->qr_code_link = 'id=Fajar-TrafoList10';
        $trafo10->created_at = Carbon::now()->toDateTimeString();
        $trafo10->updated_at = Carbon::now()->toDateTimeString();
        $trafo10->save();

        // AVAILABLE
        $trafo10 = new Trafo();
        $trafo10->id = 'ETF001234';
        $trafo10->status = 'Available';
        $trafo10->funcloc = null;
        $trafo10->sort_field = null;
        $trafo10->description = null;
        $trafo10->material_number = null;
        $trafo10->unique_id = '11';
        $trafo10->qr_code_link = 'id=Fajar-TrafoList11';
        $trafo10->created_at = Carbon::now()->toDateTimeString();
        $trafo10->updated_at = Carbon::now()->toDateTimeString();
        $trafo10->save();
    }
}
