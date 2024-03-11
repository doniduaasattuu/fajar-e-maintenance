<?php

namespace App\Models;

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

    protected $fillable = [
        'id',
        'status',
        'funcloc',
        'sort_field',
        'description',
        'material_number',
        'unique_id',
        'qr_code_link',
        'created_at',
        'updated_at',
    ];

    public function Funcloc(): BelongsTo
    {
        return $this->belongsTo(Funcloc::class, 'funcloc', 'id');
    }

    public function MotorDetail(): HasOne
    {
        return $this->hasOne(MotorDetails::class, 'motor_detail', 'id');
    }
}
