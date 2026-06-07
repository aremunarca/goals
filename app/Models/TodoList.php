<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'user_id', 'listId', 'text', 'desc', 'color', 'is_custom', 'checked', 'alarm', 'data'];
    protected $casts = [
        'is_custom' => 'boolean',
        'checked' => 'boolean',
        'alarm' => 'boolean',
        'data' => 'array',
    ];
    protected $table = 'todo_lists';
}
