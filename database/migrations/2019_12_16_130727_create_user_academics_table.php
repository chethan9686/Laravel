<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAcademicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_academics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');           
            $table->string('course_name')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('university')->nullable();  
            $table->string('location')->nullable();  
            $table->string('branch')->nullable();  
            $table->string('percentage')->nullable();  
            $table->string('class_obt')->nullable(); 
            $table->timestamps();
        });

        Schema::table('user_academics', function (Blueprint $table){
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
        Schema::dropIfExists('user_academics');
    }
}
