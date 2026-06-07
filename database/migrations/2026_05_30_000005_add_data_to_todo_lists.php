<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToTodoLists extends Migration
{
    public function up()
    {
        Schema::table('todo_lists', function (Blueprint $table) {
            $table->json('data')->nullable()->after('is_custom');
        });
    }

    public function down()
    {
        Schema::table('todo_lists', function (Blueprint $table) {
            $table->dropColumn('data');
        });
    }
}
