<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name', 255);
            $table->text('event_description');
            $table->string('event_img');
            $table->string('event_video');
            $table->dateTimeTz('event_start', 0);
            $table->dateTimeTz('event_end', 0);
            $table->double('event_payment', 8,2);
            $table->enum('event_payment_type', [0, 1, 2 ,3]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
