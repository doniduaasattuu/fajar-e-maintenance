<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EmoRecord extends Model
{
    protected $table = "emo_records";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'nik', 'nik');
    }

    protected $fillable = [
        'funcloc',
        'emo',
        'sort_field',
        'motor_status',
        'clean_status',
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
        'comment',
        'created_at',
        'nik',
    ];
}
