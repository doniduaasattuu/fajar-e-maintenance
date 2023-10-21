<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class EmoDetail extends Model
{
    protected $table = "emo_details";
    protected $keyType = "int";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = false;

    public function funcloc(): HasOneThrough
    {
        return $this->hasOneThrough(
            FunctionLocation::class,
            Emo::class,
            "id",
            "id",
            "emo_detail",
            "funcloc",
        );

        // "funcloc",
        // "id",
        // "emo_detail",
        // "id"
    }

    public function emo(): BelongsTo
    {
        return $this->belongsTo(Emo::class, "emo_detail", "id");
    }
}
