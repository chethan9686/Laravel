<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOutOfStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_out_of_stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->integer('branch')->default(0); 
            $table->unsignedInteger('tl')->default(0);
            $table->unsignedInteger('rm')->default(0);
            $table->unsignedInteger('rh')->default(0);
            $table->string('purpose_of_work')->nullable();
            $table->string('purpose_of_travel')->nullable();
            $table->string('departure_date')->nullable();
            $table->string('departure_time')->nullable();
            $table->string('arrival_date')->nullable();
            $table->string('arrival_time')->nullable();
            $table->string('event_date')->nullable();
            $table->string('event_name')->nullable();
            $table->string('event_location')->nullable();
            $table->string('travel_mode')->nullable();
            $table->string('admin_status')->nullable();
            $table->string('admin_comment')->nullable();           
            $table->integer('level')->default(0);
            $table->integer('attendence_status')->default(0);
            $table->timestamps();
        });

        Schema::table('user_out_of_stations', function (Blueprint $table){
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
        Schema::dropIfExists('user_out_of_stations');
    }
}
