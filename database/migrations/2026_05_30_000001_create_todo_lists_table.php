<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoListsTable extends Migration
{
    public function up()
    {
        Schema::create('todo_lists', function (Blueprint $table) {
            $table->id();
            $table->string('listId'); // corresponds to the IndexedDB key (date like YYYYMMDD or custom id)
            $table->string('text')->nullable(); // custom list name (if applicable)
            $table->string('desc')->nullable(); 
            $table->string('color')->nullable(); 
            $table->boolean('is_custom')->default(false);
            $table->boolean('checked')->default(false);
            $table->boolean('alarm')->default(false);
            $table->timestamps();
        });

        
    }

    public function down()
    {
        Schema::dropIfExists('todo_lists');
    }
}
