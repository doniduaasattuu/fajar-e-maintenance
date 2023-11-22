<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class FunctionLocation extends Model
{
    protected $table = "function_locations";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = true;

    public function emos(): HasMany
    {
        return $this->hasMany(Emo::class, "funcloc", "id");
    }

    public function transformers(): HasMany
    {
        return $this->hasMany(Transformers::class, "funcloc", "id");
    }

    public function emoDetail(): HasOneThrough
    {
        return $this->hasOneThrough(
            EmoDetail::class,
            Emo::class,
            "funcloc",
            "emo_detail",
            "id",
            "id",
        );
    }
}
