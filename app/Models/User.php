<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    protected $table = "users";
    protected $primaryKey = "nik";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    public function emoRecords(): BelongsTo
    {
        return $this->belongsTo(EmoRecord::class, 'nik', 'nik');
    }
}
