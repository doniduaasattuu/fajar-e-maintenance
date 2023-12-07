<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Emo extends Model
{
    protected $table = "emos";
    protected $keyType = "string";
    protected $primaryKey = "id";
    public $incrementing = false;
    public $timestamps = true;

    protected $hidden = [
        "created_at",
        // "updated_at",
        "unique_id",
        "qr_code_link",
    ];

    public function funcloc(): BelongsTo
    {
        return $this->belongsTo(FunctionLocation::class, "funcloc", "id");
    }

    public function emoDetails(): HasOne
    {
        return $this->hasOne(EmoDetail::class, "emo_detail", "id");
    }

    public function emoRecords(): HasMany
    {
        return $this->hasMany(EmoRecord::class, "emo", "id");
    }
}
