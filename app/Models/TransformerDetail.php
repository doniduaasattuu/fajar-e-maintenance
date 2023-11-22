<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class TransformerDetail extends Model
{
    protected $table = "transformer_details";
    protected $keyType = "int";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = false;

    public function funcloc(): HasOneThrough
    {
        return $this->hasOneThrough(
            FunctionLocation::class,
            Transformers::class,
            "id",
            "id",
            "transformer_detail",
            "funcloc",
        );
    }

    public function transformer(): BelongsTo
    {
        return $this->belongsTo(Transformers::class, "transformer_detail", "id");
    }
}
