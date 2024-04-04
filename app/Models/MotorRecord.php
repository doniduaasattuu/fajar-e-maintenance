<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorRecord extends Model
{
    protected $table = "motor_records";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id',
        'funcloc',
        'motor',
        'sort_field',
        'motor_status',
        'cleanliness',
        'nipple_grease',
        'number_of_greasing',
        'temperature_de',
        'temperature_body',
        'temperature_nde',
        'vibration_de_vertical_value',
        'vibration_de_vertical_desc',
        'vibration_de_horizontal_value',
        'vibration_de_horizontal_desc',
        'vibration_de_axial_value',
        'vibration_de_axial_desc',
        'vibration_de_frame_value',
        'vibration_de_frame_desc',
        'noise_de',
        'vibration_nde_vertical_value',
        'vibration_nde_vertical_desc',
        'vibration_nde_horizontal_value',
        'vibration_nde_horizontal_desc',
        'vibration_nde_frame_value',
        'vibration_nde_frame_desc',
        'noise_nde',
        'department',
        'nik',
    ];
}
