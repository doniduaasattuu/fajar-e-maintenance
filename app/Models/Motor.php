<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Motor extends Model
{
    protected $table = "motors";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = true;

    public function Funcloc(): BelongsTo
    {
        return $this->belongsTo(Funcloc::class, 'funcloc', 'id');
    }

    public function MotorDetail(): HasOne
    {
        return $this->hasOne(MotorDetails::class, 'motor_detail', 'id');
    }
}
