<?php

namespace Database\Seeders;

use App\Models\MotorRecord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotorRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $record1 = new MotorRecord();
        $record1->id = uniqid();
        $record1->funcloc = null;
        $record1->motor = null;
        $record1->sort_field = null;
        $record1->motor_status = null;
        $record1->cleanliness = null;
        $record1->nipple_grease = null;
        $record1->number_of_greasing = null;
        $record1->temperature_de = null;
        $record1->temperature_body = null;
        $record1->temperature_nde = null;
        $record1->vibration_de_vertical_value = null;
        $record1->vibration_de_vertical_desc = null;
        $record1->vibration_de_horizontal_value = null;
        $record1->vibration_de_horizontal_desc = null;
        $record1->vibration_de_axial_value = null;
        $record1->vibration_de_axial_desc = null;
        $record1->vibration_de_frame_value = null;
        $record1->vibration_de_frame_desc = null;
        $record1->noise_de = null;
        $record1->vibration_nde_vertical_value = null;
        $record1->vibration_nde_vertical_desc = null;
        $record1->vibration_nde_horizontal_value = null;
        $record1->vibration_nde_horizontal_desc = null;
        $record1->vibration_nde_frame_value = null;
        $record1->vibration_nde_frame_desc = null;
        $record1->noise_nde = null;
        $record1->nik = null;
    }
}
