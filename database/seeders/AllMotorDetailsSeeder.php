<?php

namespace Database\Seeders;

use App\Models\Motor;
use App\Models\MotorDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllMotorDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('motor_details')->truncate();
        $motors = Motor::get();
        foreach ($motors as $motor) {
            $motorDetails = new MotorDetails();
            $motorDetails->motor_detail = $motor->id;
            $motorDetails->manufacturer = 'TECO';
            $motorDetails->serial_number = 'P9543291';
            $motorDetails->type = 'AEEBPA040100YW05T';
            $motorDetails->power_rate = '75';
            $motorDetails->power_unit = 'kW';
            $motorDetails->voltage = '380';
            $motorDetails->electrical_current = 'AC';
            $motorDetails->current_nominal = '140';
            $motorDetails->frequency = '50';
            $motorDetails->pole = '4';
            $motorDetails->rpm = '1475';
            $motorDetails->bearing_de = 'NU216';
            $motorDetails->bearing_nde = '6213';
            $motorDetails->frame_type = '250 M';
            $motorDetails->shaft_diameter = null;
            $motorDetails->phase_supply = '3';
            $motorDetails->cos_phi = null;
            $motorDetails->efficiency = null;
            $motorDetails->ip_rating = '55';
            $motorDetails->insulation_class = 'F';
            $motorDetails->duty = 'S1';
            $motorDetails->connection_type = null;
            $motorDetails->nipple_grease = null;
            $motorDetails->greasing_type = null;
            $motorDetails->greasing_qty_de = null;
            $motorDetails->greasing_qty_nde = null;
            $motorDetails->length = null;
            $motorDetails->width = null;
            $motorDetails->height = '250';
            $motorDetails->weight = null;
            $motorDetails->cooling_fan = 'Internal';
            $motorDetails->mounting = 'Horizontal';
            $motorDetails->save();
        }
    }
}
