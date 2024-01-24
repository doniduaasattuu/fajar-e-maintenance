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
        $record1->funcloc = "FP-01-PM3-REL-PPRL-PRAR";
        $record1->motor = "MGM000481";
        $record1->sort_field = "PM3.REEL.PRAR/GM";
        $record1->motor_status = "Running";
        $record1->cleanliness = "Clean";
        $record1->nipple_grease = "Available";
        $record1->number_of_greasing = "120";
        $record1->temperature_de = "30.09";
        $record1->temperature_body = "30.09";
        $record1->temperature_nde = "30.09";
        $record1->vibration_de_vertical_value = "30.09";
        $record1->vibration_de_vertical_desc = "Unacceptable";
        $record1->vibration_de_horizontal_value = "30.09";
        $record1->vibration_de_horizontal_desc = "Unacceptable";
        $record1->vibration_de_axial_value = "30.09";
        $record1->vibration_de_axial_desc = "Unacceptable";
        $record1->vibration_de_frame_value = "30.09";
        $record1->vibration_de_frame_desc = "Unacceptable";
        $record1->noise_de = "Normal";
        $record1->vibration_nde_vertical_value = "30.09";
        $record1->vibration_nde_vertical_desc = "Unacceptable";
        $record1->vibration_nde_horizontal_value = "30.09";
        $record1->vibration_nde_horizontal_desc = "Unacceptable";
        $record1->vibration_nde_frame_value = "30.09";
        $record1->vibration_nde_frame_desc = "Unacceptable";
        $record1->noise_nde = "Normal";
        $record1->nik = "55000154";
        $record1->save();
    }
}
