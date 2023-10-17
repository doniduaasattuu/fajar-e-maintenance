<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emo extends Model
{
    protected $table = "emos";
    protected $keyType = "string";
    protected $primaryKey = "id";
    public $incrementing = false;
    public $timestamps = true;
}
