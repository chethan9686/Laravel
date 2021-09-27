<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDismentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dismentals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->integer('branch')->default(0); 
            $table->unsignedInteger('tl')->default(0);
            $table->unsignedInteger('rm')->default(0);
            $table->unsignedInteger('rh')->default(0);
            $table->unsignedInteger('dis_references_id')->default(0);
            $table->string('dis_clientname')->nullable();
            $table->string('dis_eventname')->nullable();
            $table->string('dis_location')->nullable();
            $table->string('dis_dateofdismantle')->nullable();
            $table->string('dis_time')->nullable();
            $table->string('dis_EWH')->nullable();
            $table->timestamps();
        });
         Schema::table('dismentals', function (Blueprint $table){
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
        Schema::dropIfExists('dismentals');
    }
}
