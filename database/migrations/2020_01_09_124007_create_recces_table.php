<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReccesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->integer('branch')->default(0); 
            $table->unsignedInteger('tl')->default(0);
            $table->unsignedInteger('rm')->default(0);
            $table->unsignedInteger('rh')->default(0);
            $table->unsignedInteger('recce_references_id')->default(0);
            $table->string('recce_clientname')->nullable();
            $table->string('recce_eventname')->nullable();
            $table->string('recce_dateofrecce')->nullable();
            $table->string('recce_time')->nullable();
            $table->string('recce_eventlcation')->nullable();
            $table->string('recce_eventenddate')->nullable();
            $table->string('recce_ERTW')->nullable();
            $table->timestamps();
        });
        Schema::table('recces', function (Blueprint $table){
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
        Schema::dropIfExists('recces');
    }
}
