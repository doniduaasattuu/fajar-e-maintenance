<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrafoRecord extends Model
{
    protected $table = "trafo_records";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id',
        'funcloc',
        'trafo',
        'sort_field',
        'trafo_status',
        'primary_current_phase_r',
        'primary_current_phase_s',
        'primary_current_phase_t',
        'secondary_current_phase_r',
        'secondary_current_phase_s',
        'secondary_current_phase_t',
        'primary_voltage',
        'secondary_voltage',
        'oil_temperature',
        'winding_temperature',
        'cleanliness',
        'noise',
        'silica_gel',
        'earthing_connection',
        'oil_leakage',
        'oil_level',
        'blower_condition',
        'nik',
    ];
}
