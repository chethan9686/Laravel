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
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->integer('branch')->default(0); 
            $table->unsignedInteger('tl')->default(0);
            $table->unsignedInteger('rm')->default(0);
            $table->unsignedInteger('rh')->default(0);
            $table->unsignedInteger('event_references_id')->default(0);
            $table->string('eventname')->nullable();
            $table->string('clientname')->nullable();
            $table->string('eventfromdate')->nullable();
            $table->string('eventtodate')->nullable();
            $table->string('eventlocation')->nullable();
            $table->text('eventdesc')->nullable();
            $table->integer('attendence_status')->default(0);
            $table->timestamps();
        });
        Schema::table('events', function (Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');            
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
