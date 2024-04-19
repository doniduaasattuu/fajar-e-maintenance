<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'issues';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'issued_date',
        'target_date',
        'remaining_days',
        'section',
        'area',
        'description',
        'corrective_action',
        'root_cause',
        'preventive_action',
        'status',
        'remark',
        'department',
        'created_by',
        'updated_by',
    ];
}
