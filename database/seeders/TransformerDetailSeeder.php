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
        $trafo_detail1 = new TransformerDetail();
        $trafo_detail1->transformer_detail = "ETF000085";
        $trafo_detail1->power_rate = "50000";
        $trafo_detail1->power_unit = "kVA";
        $trafo_detail1->primary_voltage = "150000";
        $trafo_detail1->secondary_voltage = "20000";
        $trafo_detail1->primary_current = "192";
        $trafo_detail1->secondary_current = "1443";
        $trafo_detail1->primary_connection_type = "Delta";
        $trafo_detail1->secondary_connection_type = "Star";
        $trafo_detail1->type = "Step Down";
        $trafo_detail1->manufacturer = "Unindo";
        $trafo_detail1->year_of_manufacture = "2012";
        $trafo_detail1->serial_number = "P050LEC692";
        $trafo_detail1->vector_group = "Ynyn 0 + d";
        $trafo_detail1->frequency = "50";
        $trafo_detail1->insulation_class = null;
        $trafo_detail1->type_of_cooling = "ONAN/ONAF";
        $trafo_detail1->temp_rise_oil_winding = null;
        $trafo_detail1->weight = null;
        $trafo_detail1->weight_of_oil = null;
        $trafo_detail1->oil_type = null;
        $trafo_detail1->ip_rating = null;
        $trafo_detail1->save();

        $trafo_detail2 = new TransformerDetail();
        $trafo_detail2->transformer_detail = "ETF000026";
        $trafo_detail2->power_rate = "1000";
        $trafo_detail2->power_unit = "kVA";
        $trafo_detail2->primary_voltage = "20000";
        $trafo_detail2->secondary_voltage = "400";
        $trafo_detail2->primary_current = "28.87";
        $trafo_detail2->secondary_current = "1443";
        $trafo_detail2->primary_connection_type = "Delta";
        $trafo_detail2->secondary_connection_type = "Star";
        $trafo_detail2->type = "Step Down";
        $trafo_detail2->manufacturer = "Pauwels Trafo";
        $trafo_detail2->year_of_manufacture = "1995";
        $trafo_detail2->serial_number = "3417186";
        $trafo_detail2->vector_group = "Dyn11";
        $trafo_detail2->frequency = "50";
        $trafo_detail2->insulation_class = null;
        $trafo_detail2->type_of_cooling = "ONAN";
        $trafo_detail2->temp_rise_oil_winding = null;
        $trafo_detail2->weight = null;
        $trafo_detail2->weight_of_oil = "510";
        $trafo_detail2->oil_type = null;
        $trafo_detail2->ip_rating = null;
        $trafo_detail2->save();
    }
}
