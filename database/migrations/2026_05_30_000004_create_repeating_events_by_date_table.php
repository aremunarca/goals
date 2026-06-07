<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepeatingEventsByDateTable extends Migration
{
    public function up()
    {
        Schema::create('repeating_events_by_date', function (Blueprint $table) {
            $table->string('date')->primary(); // date key (e.g. YYYYMMDD)
            $table->json('data')->nullable(); // generated repeating events map for that date
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('repeating_events_by_date');
    }
}
