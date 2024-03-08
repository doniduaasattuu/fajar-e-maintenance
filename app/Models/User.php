<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    protected $fillable = [
        'nik',
        'password',
        'fullname',
        'department',
        'phone_number',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role', 'nik', 'role');
    }

    public function isAdmin(): bool
    {
        return !is_null($this->roles->where('role', 'admin')->first());
    }

    public function isSuperAdmin(): bool
    {
        return !is_null($this->roles->where('role', 'superadmin')->first());
    }

    public function abbreviatedName(): Attribute
    {
        $names = explode(' ', $this->fullname);

        return new Attribute(
            get: fn () => (sizeof($names) > 2) ? $names[0] . ' ' . $names[1] . ' ' . $names[2][0]  : $this->fullname
        );
    }

    public function printedName(): Attribute
    {
        $names = explode(' ', $this->abbreviated_name);

        return new Attribute(
            get: fn () => (strlen($names[0]) < 3) ? $names[0] . ' ' . $names[1] : $names[0]
        );
    }
}
