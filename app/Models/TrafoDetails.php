<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
