<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transformers extends Model
{
    protected $table  = "transformers";
    protected $keyType = "string";
    protected $primaryKey = "id";
    public $incrementing = false;
    public $timestamps = true;

    protected $hidden = [
        "created_at",
        "unique_id",
        "qr_code_link",
    ];

    public function funcloc(): BelongsTo
    {
        return $this->belongsTo(FunctionLocation::class, "funcloc", "id");
    }

    public function transformerDetails(): HasOne
    {
        return $this->hasOne(TransformerDetail::class, "transformer_detail", "id");
    }
}
