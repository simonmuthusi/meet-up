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
        Schema::enableForeignKeyConstraints();
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('name');
            $table->dateTime('event_from_date');
            $table->dateTime('event_to_date');
            $table->string('location');
            $table->text('description');
            $table->string('attachment')->nullable();
            $table->enum('status', $this->STATUSES)->default("draft");
            $table->boolean('send_notification');
            $table->boolean('is_active')->default(true);
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
