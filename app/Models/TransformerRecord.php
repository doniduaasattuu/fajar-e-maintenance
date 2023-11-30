<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TransformerRecord extends Model
{
    protected $table = "transformer_records";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'nik', 'nik');
    }

    protected $fillable = [
        "funcloc",
        "transformer",
        "sort_field",
        "transformer_status",
        "primary_current_phase_r",
        "primary_current_phase_s",
        "primary_current_phase_t",
        "secondary_current_phase_r",
        "secondary_current_phase_s",
        "secondary_current_phase_t",
        "primary_voltage",
        "secondary_voltage",
        "oil_temperature",
        "winding_temperature",
        "clean_status",
        "noise",
        "silica_gel",
        "earthing_connection",
        "oil_leakage",
        "oil_level",
        "blower_condition",
        "comment",
        "created_at",
        "nik",
    ];
}
