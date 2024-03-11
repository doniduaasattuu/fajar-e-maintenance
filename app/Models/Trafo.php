<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Trafo extends Model
{
    protected $table = "trafos";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = true;

    public function Funcloc(): BelongsTo
    {
        return $this->belongsTo(Funcloc::class, 'funcloc', 'id');
    }

    public function TrafoDetail(): HasOne
    {
        return $this->hasOne(TrafoDetails::class, 'trafo_detail', 'id');
    }
}
