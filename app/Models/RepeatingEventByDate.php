<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepeatingEventByDate extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['date','data'];
    protected $casts = [
        'data' => 'array',
    ];
    protected $table = 'repeating_events_by_date';
    protected $primaryKey = 'date';
}
