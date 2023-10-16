<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";
    protected $primaryKey = "nik";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;
}
