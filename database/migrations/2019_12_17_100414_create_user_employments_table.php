<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEmploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_employments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');  
            $table->string('duration_from',150)->nullable();
            $table->string('duration_to',150)->nullable();
            $table->string('duration_month',150)->nullable();
            $table->string('organization',150)->nullable();
            $table->string('designation',150)->nullable();
            $table->string('role',150)->nullable();
            $table->text('leaving',150)->nullable();   
            $table->timestamps();
        });

        Schema::table('user_employments', function (Blueprint $table){
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
        Schema::dropIfExists('user_employments');
    }
}
