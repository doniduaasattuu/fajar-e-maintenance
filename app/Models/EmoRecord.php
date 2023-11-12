<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EmoRecord extends Model
{
    protected $table = "emo_records";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'nik', 'nik');
    }
}
