<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepeatingEventsTable extends Migration
{
    public function up()
    {
        Schema::create('repeating_events', function (Blueprint $table) {
            $table->string('id')->primary(); // id used in IndexedDB
            $table->unsignedTinyInteger('type')->nullable(); // frequency type (daily, weekly, ...)
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->text('repeating_rule')->nullable();
            $table->string('ocurrencesType')->nullable();
            $table->json('data')->nullable(); // original `data` object (task template)
            $table->unsignedInteger('list_id'); // original `data` object (task template)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('repeating_events');
    }
}
