<?php

namespace Database\Seeders;

use App\Models\EmoDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmoDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emo_detail = new EmoDetail();
        $emo_detail->emo_detail = "EMO000426";
        $emo_detail->manufacture = "TECO";
        $emo_detail->serial_number = "P9543291";
        $emo_detail->type = "AEEBPA040100YW05T";
        $emo_detail->power_rate = "75";
        $emo_detail->power_unit = "kW";
        $emo_detail->voltage = "380";
        $emo_detail->current_nominal = "140";
        $emo_detail->frequency = "50";
        $emo_detail->pole = "4";
        $emo_detail->rpm = "1475";
        $emo_detail->bearing_de = "NU216";
        $emo_detail->bearing_nde = "6213";
        $emo_detail->frame_type = "250 M";
        $emo_detail->shaft_diameter = 75;
        $emo_detail->phase_supply = "3";
        $emo_detail->cos_phi = "0.84";
        $emo_detail->efficiency = null;
        $emo_detail->ip_rating = "55";
        $emo_detail->insulation_class = "F";
        $emo_detail->duty = "S1";
        $emo_detail->connection_type = "Star-Delta";
        $emo_detail->nipple_grease = "Available";
        $emo_detail->greasing_type = null;
        $emo_detail->greasing_qty_de = null;
        $emo_detail->greasing_qty_nde = null;
        $emo_detail->length = null;
        $emo_detail->width = null;
        $emo_detail->height = 250;
        $emo_detail->weight = null;
        $emo_detail->cooling_fan = "Internal";
        $emo_detail->mounting = "Horizontal";
        $emo_detail->save();

        $emo_detail1 = new EmoDetail();
        $emo_detail1->emo_detail = "MGM000481";
        $emo_detail1->manufacture = "Sumitomo";
        $emo_detail1->serial_number = "M5064051";
        $emo_detail1->type = "IC-F/FB-B8";
        $emo_detail1->power_rate = "5.5";
        $emo_detail1->power_unit = "kW";
        $emo_detail1->voltage = "380";
        $emo_detail1->current_nominal = "11.5";
        $emo_detail1->frequency = "50";
        $emo_detail1->pole = "4";
        $emo_detail1->rpm = "1410";
        $emo_detail1->bearing_de = "6206";
        $emo_detail1->bearing_nde = "6206";
        $emo_detail1->frame_type = "F132S";
        $emo_detail1->phase_supply = "3";
        $emo_detail1->cos_phi = "0.84";
        $emo_detail1->efficiency = null;
        $emo_detail1->ip_rating = "44";
        $emo_detail1->insulation_class = "B";
        $emo_detail1->duty = "S1";
        $emo_detail1->connection_type = "Star-Delta";
        $emo_detail1->nipple_grease = "Not Available";
        $emo_detail1->greasing_type = null;
        $emo_detail1->greasing_qty_de = null;
        $emo_detail1->greasing_qty_nde = null;
        $emo_detail1->length = null;
        $emo_detail1->width = null;
        $emo_detail1->height = 132;
        $emo_detail1->weight = null;
        $emo_detail1->cooling_fan = "Internal";
        $emo_detail1->mounting = "Vertical";
        $emo_detail1->save();

        $emo_detail2 = new EmoDetail();
        $emo_detail2->emo_detail = "EMO001056";
        $emo_detail2->manufacture = "TECO";
        $emo_detail2->serial_number = "P9524661";
        $emo_detail2->type = "AEVB";
        $emo_detail2->power_rate = "3";
        $emo_detail2->power_unit = "kW";
        $emo_detail2->voltage = "380";
        $emo_detail2->current_nominal = "7.1";
        $emo_detail2->frequency = "50";
        $emo_detail2->pole = "4";
        $emo_detail2->rpm = "1400";
        $emo_detail2->bearing_de = "6206";
        $emo_detail2->bearing_nde = "6305";
        $emo_detail2->frame_type = "100L";
        $emo_detail2->phase_supply = "3";
        $emo_detail2->ip_rating = "55";
        $emo_detail2->insulation_class = "F";
        $emo_detail2->connection_type = "Delta";
        $emo_detail2->nipple_grease = "Not Available";
        $emo_detail2->greasing_type = null;
        $emo_detail2->greasing_qty_de = null;
        $emo_detail2->greasing_qty_nde = null;
        $emo_detail2->length = null;
        $emo_detail2->width = null;
        $emo_detail2->height = 100;
        $emo_detail2->weight = null;
        $emo_detail2->cooling_fan = "Internal";
        $emo_detail2->mounting = "Vertical";
        $emo_detail2->save();

        $emo_detail3 = new EmoDetail();
        $emo_detail3->emo_detail = "EMO004493";
        $emo_detail3->manufacture = "TMEIC";
        $emo_detail3->serial_number = "E167050HF";
        $emo_detail3->type = "IDF-CHKWII";
        $emo_detail3->power_rate = "750";
        $emo_detail3->power_unit = "kW";
        $emo_detail3->voltage = "690";
        $emo_detail3->current_nominal = "770";
        $emo_detail3->frequency = "50";
        $emo_detail3->pole = "6";
        $emo_detail3->rpm = "1150";
        $emo_detail3->bearing_de = "6228";
        $emo_detail3->bearing_nde = "6228";
        $emo_detail3->frame_type = "450";
        $emo_detail3->phase_supply = "3";
        $emo_detail3->ip_rating = "44";
        $emo_detail3->insulation_class = "F";
        $emo_detail3->connection_type = "Delta";
        $emo_detail3->nipple_grease = "Available";
        $emo_detail3->greasing_type = null;
        $emo_detail3->greasing_qty_de = null;
        $emo_detail3->greasing_qty_nde = null;
        $emo_detail3->length = null;
        $emo_detail3->width = null;
        $emo_detail3->height = 450;
        $emo_detail3->weight = null;
        $emo_detail3->cooling_fan = "Internal";
        $emo_detail3->mounting = "Horizontal";
        $emo_detail3->save();
    }
}
