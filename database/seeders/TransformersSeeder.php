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
        $trafo = new Transformers();
        $trafo->id = "ETF000085";
        $trafo->status = "Installed";
        $trafo->funcloc = "FP-01-IN1";
        $trafo->sort_field = "TRAFO;STEP DOWN;150/20kV;UNINDO 50 KVA;";
        $trafo->material_number = null;
        $trafo->equipment_description = "TRAFO PLN";
        $trafo->unique_id = "1";
        $trafo->qr_code_link = "id=Fajar-TrafoList1";
        $trafo->created_at = Carbon::now()->toDateTimeString();
        $trafo->updated_at = Carbon::now()->toDateTimeString();
        $trafo->save();
    }
}
