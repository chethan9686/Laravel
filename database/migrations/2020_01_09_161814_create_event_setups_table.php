<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_setups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->integer('branch')->default(0); 
            $table->unsignedInteger('tl')->default(0);
            $table->unsignedInteger('rm')->default(0);
            $table->unsignedInteger('rh')->default(0);
            $table->unsignedInteger('setup_references_id')->default(0);
            $table->string('setup_clientname')->nullable();
            $table->string('setup_eventstartdate')->nullable();
            $table->string('setup_eventenddate')->nullable();
            $table->string('setup_time')->nullable();
            $table->string('setup_eventlcation')->nullable();
            $table->string('setup_EWH')->nullable();
            $table->integer('attendence_status')->default(0);
            $table->timestamps();
        });
        Schema::table('event_setups', function (Blueprint $table){
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
        Schema::dropIfExists('event_setups');
    }
}
