<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Funcloc extends Model
{
    protected $table = "funclocs";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = true;

    public function Motors(): HasMany
    {
        return $this->hasMany(Motor::class, "funcloc", "id");
    }
}
