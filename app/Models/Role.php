<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Role extends Model
{
    protected $table = "roles";
    protected $primaryKey = "role";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = true;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role', 'role', 'nik');
    }

    public function userAsAdmin()
    {
        return $this->users->where('role', '=', 'admin')->get();
    }
}
