<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class FunctionLocation extends Model
{
    protected $table = "function_locations";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    public function emoChild(): BelongsTo
    {
        return $this->belongsTo(Emo::class, "emo", "id");
    }

    public function emoDetail(): HasOneThrough
    {
        return $this->hasOneThrough(EmoDetail::class, Emo::class, "id", "emo", "emo", "id");
    }
}
