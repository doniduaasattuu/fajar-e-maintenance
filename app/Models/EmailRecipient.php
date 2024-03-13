<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailRecipient extends Model
{
    protected $table = 'email_recipients';
    protected $primaryKey = 'email';
    protected $keyType = 'string';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'email',
        'created_at',
        'updated_at',
    ];
}
