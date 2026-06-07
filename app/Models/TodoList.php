<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'name', 'is_custom', 'data'];
    protected $casts = [
        'is_custom' => 'boolean',
        'data' => 'array',
    ];
    protected $table = 'todo_lists';
}
