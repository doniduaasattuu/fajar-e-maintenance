<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class TrafoDetails extends Model
{
    protected $table = "trafo_details";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    public function Trafo(): BelongsTo
    {
        return $this->belongsTo(Trafo::class, 'trafo_detail', 'id');
    }

    public function Funcloc(): HasOneThrough
    {
        return $this->hasOneThrough(
            Funcloc::class,
            Trafo::class,
            'id',
            'id',
            'trafo_detail',
            'funcloc',
        );
    }
}
