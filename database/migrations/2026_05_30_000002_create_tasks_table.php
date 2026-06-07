<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('list_id')->index(); // corresponds to the todo_lists key
            $table->text('text')->nullable();
            $table->boolean('checked')->default(false);
            $table->text('desc')->nullable();
            $table->json('sub_task_list')->nullable(); // array of subtasks
            $table->string('color')->nullable();
            $table->integer('priority')->default(0);
            $table->json('tags')->nullable();
            $table->string('time')->nullable();
            $table->boolean('alarm')->default(false);
            $table->string('repeating_event_id')->nullable();
            $table->integer('position')->nullable(); // for ordering
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
