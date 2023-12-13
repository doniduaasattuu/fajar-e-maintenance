<?php

namespace Database\Seeders;

use App\Models\Transformers;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransformersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trafo1 = new Transformers();
        $trafo1->id = "ETF000085";
        $trafo1->status = "Installed";
        $trafo1->funcloc = "FP-01-IN1";
        $trafo1->sort_field = "TRAFO PLN";
        $trafo1->material_number = null;
        $trafo1->equipment_description = "TRAFO;STEP DOWN;150/20kV;UNINDO 50 KVA;";
        $trafo1->unique_id = "1";
        $trafo1->qr_code_link = "id=Fajar-TrafoList1";
        $trafo1->created_at = Carbon::now()->toDateTimeString();
        $trafo1->updated_at = Carbon::now()->toDateTimeString();
        $trafo1->save();

        $trafo2 = new Transformers();
        $trafo2->id = "ETF000026";
        $trafo2->status = "Installed";
        $trafo2->funcloc = "FP-01-GT2-TRF-PWP2";
        $trafo2->sort_field = "TR AUX GTG #1 lama";
        $trafo2->material_number = null;
        $trafo2->equipment_description = "TR AUX GTG #1";
        $trafo2->unique_id = "4";
        $trafo2->qr_code_link = "id=Fajar-TrafoList4";
        $trafo2->created_at = Carbon::now()->toDateTimeString();
        $trafo2->updated_at = Carbon::now()->toDateTimeString();
        $trafo2->save();
    }
}
