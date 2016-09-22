<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $STATUSES = ['draft','not attending','attending'];
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('name');
            $table->dateTime('event_from_date');
            $table->dateTime('event_to_date');
            $table->string('location');
            $table->text('description');
            $table->string('attachment');
            $table->enum('status', $this->STATUSES);
            $table->boolean('send_notification');
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
