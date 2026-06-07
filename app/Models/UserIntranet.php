<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserIntranet extends Model
{
    protected $connection = 'mysql_intranet';
    protected $table = 'users';
}
