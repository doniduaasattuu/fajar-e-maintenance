<?php

namespace Database\Seeders;

use App\Models\TransformerDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransformerDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trafo_detail = new TransformerDetail();
        $trafo_detail->transformer_detail = "ETF000085";
        $trafo_detail->power_rate = "50000";
        $trafo_detail->power_unit = "kVA";
        $trafo_detail->primary_voltage = "150000";
        $trafo_detail->secondary_voltage = "20000";
        $trafo_detail->primary_current = "192";
        $trafo_detail->secondary_current = "1443";
        $trafo_detail->primary_connection_type = "Delta";
        $trafo_detail->secondary_connection_type = "Star";
        $trafo_detail->type = "Step Down";
        $trafo_detail->manufacturer = "Unindo";
        $trafo_detail->year_of_manufacture = "2012";
        $trafo_detail->serial_number = "P050LEC692";
        $trafo_detail->vector_group = "Ynyn 0 + d";
        $trafo_detail->frequency = "50";
        $trafo_detail->insulation_class = null;
        $trafo_detail->type_of_cooling = "ONAN/ONAF";
        $trafo_detail->temp_rise_oil_winding = null;
        $trafo_detail->weight = null;
        $trafo_detail->weight_of_oil = null;
        $trafo_detail->oil_type = null;
        $trafo_detail->ip_rating = null;
        $trafo_detail->save();
    }
}
