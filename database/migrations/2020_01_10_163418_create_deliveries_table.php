<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->integer('branch')->default(0); 
            $table->unsignedInteger('tl')->default(0);
            $table->unsignedInteger('rm')->default(0);
            $table->unsignedInteger('rh')->default(0);
            $table->unsignedInteger('delivery_references_id')->default(0);
            $table->string('delry_clientname')->nullable();
            $table->string('delry_lcation')->nullable();
            $table->string('delry_dateofdelivery')->nullable();
            $table->string('delry_time')->nullable();
            $table->string('purposeofdelivery')->nullable();
            $table->string('itemdescription')->nullable();
            $table->string('delry_ERTW')->nullable();
            $table->timestamps();
        });
        Schema::table('deliveries', function (Blueprint $table){
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
        Schema::dropIfExists('deliveries');
    }
}
