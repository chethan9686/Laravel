<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBsNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bs_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id'); 
            $table->unsignedInteger('signup_id');
            $table->string('bs_number')->nullable();
            $table->timestamps();
        });

        Schema::table('bs_numbers', function (Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');    
            $table->foreign('signup_id')->references('id')->on('business_signups');                      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bs_numbers');
    }
}
