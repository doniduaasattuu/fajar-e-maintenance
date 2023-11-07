<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrators extends Model
{
    protected $table = "administrators";
    protected $primaryKey = "admin_nik";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;
}
