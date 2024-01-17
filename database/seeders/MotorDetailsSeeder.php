<?php

namespace Database\Seeders;

use App\Models\MotorDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotorDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $motorDetails1 = new MotorDetails();
        $motorDetails1->motor_detail = 'EMO000426';
        $motorDetails1->manufacturer = 'TECO';
        $motorDetails1->serial_number = 'P9543291';
        $motorDetails1->type = 'AEEBPA040100YW05T';
        $motorDetails1->power_rate = '75';
        $motorDetails1->power_unit = 'kW';
        $motorDetails1->voltage = '380';
        $motorDetails1->electrical_current = 'AC';
        $motorDetails1->current_nominal = '140';
        $motorDetails1->frequency = '50';
        $motorDetails1->pole = '4';
        $motorDetails1->rpm = '1475';
        $motorDetails1->bearing_de = 'NU216';
        $motorDetails1->bearing_nde = '6213';
        $motorDetails1->frame_type = '250 M';
        $motorDetails1->shaft_diameter = null;
        $motorDetails1->phase_supply = '3';
        $motorDetails1->cos_phi = null;
        $motorDetails1->efficiency = null;
        $motorDetails1->ip_rating = '55';
        $motorDetails1->insulation_class = 'F';
        $motorDetails1->duty = 'S1';
        $motorDetails1->connection_type = null;
        $motorDetails1->nipple_grease = null;
        $motorDetails1->greasing_type = null;
        $motorDetails1->greasing_qty_de = null;
        $motorDetails1->greasing_qty_nde = null;
        $motorDetails1->length = null;
        $motorDetails1->width = null;
        $motorDetails1->height = '250';
        $motorDetails1->weight = null;
        $motorDetails1->cooling_fan = 'Internal';
        $motorDetails1->mounting = 'Horizontal';
        $motorDetails1->save();

        $motorDetails2 = new MotorDetails();
        $motorDetails2->motor_detail = 'MGM000481';
        $motorDetails2->manufacturer = 'Sumitomo';
        $motorDetails2->serial_number = 'M5064051';
        $motorDetails2->type = 'IC-F/FB-B8';
        $motorDetails2->power_rate = '5.5';
        $motorDetails2->power_unit = 'kW';
        $motorDetails2->voltage = '380';
        $motorDetails2->electrical_current = 'AC';
        $motorDetails2->current_nominal = '11.5';
        $motorDetails2->frequency = '50';
        $motorDetails2->pole = '4';
        $motorDetails2->rpm = '1410';
        $motorDetails2->bearing_de = '6206';
        $motorDetails2->bearing_nde = '6206';
        $motorDetails2->frame_type = 'F132S';
        $motorDetails2->shaft_diameter = null;
        $motorDetails2->phase_supply = '3';
        $motorDetails2->cos_phi = null;
        $motorDetails2->efficiency = null;
        $motorDetails2->ip_rating = '44';
        $motorDetails2->insulation_class = 'B';
        $motorDetails2->duty = 'S1';
        $motorDetails2->connection_type = 'Delta';
        $motorDetails2->nipple_grease = 'Not Available';
        $motorDetails2->greasing_type = null;
        $motorDetails2->greasing_qty_de = null;
        $motorDetails2->greasing_qty_nde = null;
        $motorDetails2->length = null;
        $motorDetails2->width = null;
        $motorDetails2->height = '132';
        $motorDetails2->weight = null;
        $motorDetails2->cooling_fan = 'Internal';
        $motorDetails2->mounting = 'Vertical';
        $motorDetails2->save();

        $motorDetails3 = new MotorDetails();
        $motorDetails3->motor_detail = 'EMO001056';
        $motorDetails3->manufacturer = 'TECO';
        $motorDetails3->serial_number = 'P9543291';
        $motorDetails3->type = 'AEEBPA040100YW05T';
        $motorDetails3->power_rate = '75';
        $motorDetails3->power_unit = 'kW';
        $motorDetails3->voltage = '380';
        $motorDetails3->electrical_current = 'AC';
        $motorDetails3->current_nominal = '140';
        $motorDetails3->frequency = '50';
        $motorDetails3->pole = '4';
        $motorDetails3->rpm = '1475';
        $motorDetails3->bearing_de = 'NU216';
        $motorDetails3->bearing_nde = '6213';
        $motorDetails3->frame_type = '250 M';
        $motorDetails3->shaft_diameter = null;
        $motorDetails3->phase_supply = '3';
        $motorDetails3->cos_phi = null;
        $motorDetails3->efficiency = null;
        $motorDetails3->ip_rating = '55';
        $motorDetails3->insulation_class = 'F';
        $motorDetails3->duty = 'S1';
        $motorDetails3->connection_type = null;
        $motorDetails3->nipple_grease = null;
        $motorDetails3->greasing_type = null;
        $motorDetails3->greasing_qty_de = null;
        $motorDetails3->greasing_qty_nde = null;
        $motorDetails3->length = null;
        $motorDetails3->width = null;
        $motorDetails3->height = '250';
        $motorDetails3->weight = null;
        $motorDetails3->cooling_fan = 'Internal';
        $motorDetails3->mounting = 'Horizontal';
        $motorDetails3->save();

        $motorDetails4 = new MotorDetails();
        $motorDetails4->motor_detail = 'EMO004493';
        $motorDetails4->manufacturer = 'TECO';
        $motorDetails4->serial_number = 'P9543291';
        $motorDetails4->type = 'AEEBPA040100YW05T';
        $motorDetails4->power_rate = '75';
        $motorDetails4->power_unit = 'kW';
        $motorDetails4->voltage = '380';
        $motorDetails4->electrical_current = 'AC';
        $motorDetails4->current_nominal = '140';
        $motorDetails4->frequency = '50';
        $motorDetails4->pole = '4';
        $motorDetails4->rpm = '1475';
        $motorDetails4->bearing_de = 'NU216';
        $motorDetails4->bearing_nde = '6213';
        $motorDetails4->frame_type = '250 M';
        $motorDetails4->shaft_diameter = null;
        $motorDetails4->phase_supply = '3';
        $motorDetails4->cos_phi = null;
        $motorDetails4->efficiency = null;
        $motorDetails4->ip_rating = '55';
        $motorDetails4->insulation_class = 'F';
        $motorDetails4->duty = 'S1';
        $motorDetails4->connection_type = null;
        $motorDetails4->nipple_grease = null;
        $motorDetails4->greasing_type = null;
        $motorDetails4->greasing_qty_de = null;
        $motorDetails4->greasing_qty_nde = null;
        $motorDetails4->length = null;
        $motorDetails4->width = null;
        $motorDetails4->height = '250';
        $motorDetails4->weight = null;
        $motorDetails4->cooling_fan = 'Internal';
        $motorDetails4->mounting = 'Horizontal';
        $motorDetails4->save();

        $motorDetails5 = new MotorDetails();
        $motorDetails5->motor_detail = 'EMO003604';
        $motorDetails5->manufacturer = 'TECO';
        $motorDetails5->serial_number = 'P9543291';
        $motorDetails5->type = 'AEEBPA040100YW05T';
        $motorDetails5->power_rate = '75';
        $motorDetails5->power_unit = 'kW';
        $motorDetails5->voltage = '380';
        $motorDetails5->electrical_current = 'AC';
        $motorDetails5->current_nominal = '140';
        $motorDetails5->frequency = '50';
        $motorDetails5->pole = '4';
        $motorDetails5->rpm = '1475';
        $motorDetails5->bearing_de = 'NU216';
        $motorDetails5->bearing_nde = '6213';
        $motorDetails5->frame_type = '250 M';
        $motorDetails5->shaft_diameter = null;
        $motorDetails5->phase_supply = '3';
        $motorDetails5->cos_phi = null;
        $motorDetails5->efficiency = null;
        $motorDetails5->ip_rating = '55';
        $motorDetails5->insulation_class = 'F';
        $motorDetails5->duty = 'S1';
        $motorDetails5->connection_type = null;
        $motorDetails5->nipple_grease = null;
        $motorDetails5->greasing_type = null;
        $motorDetails5->greasing_qty_de = null;
        $motorDetails5->greasing_qty_nde = null;
        $motorDetails5->length = null;
        $motorDetails5->width = null;
        $motorDetails5->height = '250';
        $motorDetails5->weight = null;
        $motorDetails5->cooling_fan = 'Internal';
        $motorDetails5->mounting = 'Horizontal';
        $motorDetails5->save();
    }
}