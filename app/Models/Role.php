<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Role extends Model
{
    protected $table = "roles";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = true;
    public $timestamps = true;

    public function User(): HasOne
    {
        return $this->hasOne(User::class, 'nik', 'nik');
    }
}
