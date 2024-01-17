<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class MotorDetails extends Model
{
    protected $table = "motor_details";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $attributes = [
        'power_unit' => 'kW',
        'electrical_current' => 'AC',
        'nipple_grease' => 'Available',
        'cooling_fan' => 'Available',
        'mounting' => 'Horizontal'
    ];

    public function Motor(): BelongsTo
    {
        return $this->belongsTo(Motor::class, 'motor_detail', 'id');
    }

    public function Funcloc(): HasOneThrough
    {
        return $this->hasOneThrough(
            Funcloc::class,
            Motor::class,
            'id',
            'id',
            'motor_detail',
            'funcloc'
        );
    }
}
