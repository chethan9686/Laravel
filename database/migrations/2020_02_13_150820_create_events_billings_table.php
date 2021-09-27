<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_billings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');     
            $table->string('branch',100)->nullable();
            $table->string('year',100)->nullable();          
            $table->string('April',100)->nullable();
            $table->string('May',100)->nullable();
            $table->string('June',100)->nullable();
            $table->string('July',100)->nullable();
            $table->string('Agust',100)->nullable();
            $table->string('September',100)->nullable();
            $table->string('October',100)->nullable();
            $table->string('November',100)->nullable();
            $table->string('December',100)->nullable();
            $table->string('January',100)->nullable();
            $table->string('February',100)->nullable();
            $table->string('March',100)->nullable();
            $table->timestamps();
        });
        Schema::table('events_billings', function (Blueprint $table){
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
        Schema::dropIfExists('events_billings');
    }
}
