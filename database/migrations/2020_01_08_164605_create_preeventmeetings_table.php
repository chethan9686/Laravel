<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreeventmeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preeventmeetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->integer('branch')->default(0); 
            $table->unsignedInteger('tl')->default(0);
            $table->unsignedInteger('rm')->default(0);
            $table->unsignedInteger('rh')->default(0);
            $table->unsignedInteger('pem_references_id')->default(0);
            $table->string('pem_clientname')->nullable();
            $table->string('pem_dateofmeeting')->nullable();
            $table->string('pem_time')->nullable();
            $table->string('pem_eventstartdate')->nullable();
            $table->string('pem_lcation')->nullable();
            $table->string('pem_ERTW')->nullable();
            $table->timestamps();
        });
         Schema::table('preeventmeetings', function (Blueprint $table){
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
        Schema::dropIfExists('preeventmeetings');
    }
}
