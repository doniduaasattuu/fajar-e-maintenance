<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PubShare extends Model
{
    protected $table = 'pub_shares';
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id',
        'title',
        'nik',
        'attachment',
    ];
}
