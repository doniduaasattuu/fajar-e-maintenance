<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finding extends Model
{
    protected $table = "findings";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = true;
    public $timestamps = true;
}
