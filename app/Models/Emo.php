<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Emo extends Model
{
    protected $table = "emos";
    protected $keyType = "string";
    protected $primaryKey = "id";
    public $incrementing = false;
    public $timestamps = true;

    public function funcloc(): BelongsTo
    {
        return $this->belongsTo(FunctionLocation::class, "funcloc", "id");
    }

    public function emoDetails(): HasOne
    {
        return $this->hasOne(EmoDetail::class, "emo_detail", "id");
    }
}
