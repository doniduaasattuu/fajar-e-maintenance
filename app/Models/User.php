<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = "users";
    protected $primaryKey = "nik";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = true;

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'nik', 'nik');
    }

    public function isAdmin(): bool
    {
        $userRoles = $this->roles;
        $roles = $userRoles->map(function ($value, $key) {
            return $value->role;
        });

        return $roles->contains('admin');
    }

    public function isDbAdmin(): bool
    {
        $userRoles = $this->roles;
        $roles = $userRoles->map(function ($value, $key) {
            return $value->role;
        });

        return $roles->contains('db_admin');
    }

    public function abbreviatedName(): Attribute
    {
        $names = explode(' ', $this->fullname);

        return new Attribute(
            get: fn () => (sizeof($names) > 2) ? $names[0] . ' ' . $names[1] . ' ' . $names[2][0]  : $this->fullname
        );
    }
}
