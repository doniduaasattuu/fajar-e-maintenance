<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    // public function userAsAdmin()
    // {
    //     return $this->users->where('role', '=', 'admin')->get();
    // }
}
