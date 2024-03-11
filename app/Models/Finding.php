<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finding extends Model
{
    protected $table = "findings";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = true;

    protected $attributes = [
        'status' => 'Open'
    ];

    protected $fillable = [
        'id',
        'area',
        'status',
        'equipment',
        'funcloc',
        'notification',
        'reporter',
        'description',
        'image',
    ];
}
