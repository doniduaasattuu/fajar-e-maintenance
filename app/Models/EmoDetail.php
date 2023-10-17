<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmoDetail extends Model
{
    protected $table = "emo_details";
    protected $keyType = "int";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = false;

    public function emoParent(): BelongsTo
    {
        return $this->belongsTo(Emo::class, "emo", "id");
    }
}
