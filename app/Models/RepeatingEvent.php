<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepeatingEvent extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id','type','start_date','repeating_rule','data'];
    protected $casts = [
        'data' => 'array',
        'start_date' => 'datetime',
    ];
    protected $table = 'repeating_events';
}
