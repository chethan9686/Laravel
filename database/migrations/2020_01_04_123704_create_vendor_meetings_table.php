<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->integer('branch')->default(0); 
            $table->unsignedInteger('tl')->default(0);
            $table->unsignedInteger('rm')->default(0);
            $table->unsignedInteger('rh')->default(0);
            $table->unsignedInteger('references_id')->default(0);
            $table->string('vendor_name')->nullable();
            $table->string('vendor_eventname')->nullable();
            $table->string('location')->nullable();
            $table->string('vendor_dateofmeeting')->nullable();
            $table->string('vendor_time')->nullable();
            $table->string('vendor_ERTW')->nullable();
            $table->string('vendor_purpose')->nullable();
            $table->timestamps();
        });
        Schema::table('vendor_meetings', function (Blueprint $table){
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
        Schema::dropIfExists('vendor_meetings');
    }
}
