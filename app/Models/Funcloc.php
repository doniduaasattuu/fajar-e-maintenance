<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

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

    public function MotorDetail(): HasOneThrough
    {
        return $this->hasOneThrough(
            MotorDetails::class,
            Motor::class,
            "funcloc",
            "motor_detail",
            "id",
            "id",
        );
    }

    public function area(): Attribute
    {
        return new Attribute(
            get: fn () => explode('-', $this->id)[2]
        );
    }
}
