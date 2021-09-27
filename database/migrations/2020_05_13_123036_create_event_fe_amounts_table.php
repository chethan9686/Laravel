<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventFeAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_fe_amounts', function (Blueprint $table) {            
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');   
            $table->string('branch',100)->nullable();  
            $table->string('year',100)->nullable();          
            $table->string('April',100)->default(0);
            $table->string('May',100)->default(0);
            $table->string('June',100)->default(0);
            $table->string('July',100)->default(0);
            $table->string('Agust',100)->default(0);
            $table->string('September',100)->default(0);
            $table->string('October',100)->default(0);
            $table->string('November',100)->default(0);
            $table->string('December',100)->default(0);
            $table->string('January',100)->default(0);
            $table->string('February',100)->default(0);
            $table->string('March',100)->default(0);
            $table->timestamps();
        });
        Schema::table('event_fe_amounts', function (Blueprint $table){
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
        Schema::dropIfExists('event_fe_amounts');
    }
}
