<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_meetings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->integer('branch')->default(0); 
            $table->unsignedInteger('tl')->default(0);
            $table->unsignedInteger('rm')->default(0);
            $table->unsignedInteger('rh')->default(0);
            $table->string('company_status')->nullable();
            $table->string('company_name')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_email')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('duration')->nullable();
            $table->string('eta')->nullable();
            $table->string('location')->nullable();
            $table->string('purpose_of_meeting')->nullable();
            $table->string('meeting_status')->nullable();    
            $table->text('reason')->nullable();                
            $table->integer('referred_id')->nullable();
            $table->integer('attendence_update')->default(0);
            $table->timestamps();
        });

        Schema::table('user_meetings', function (Blueprint $table){
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
        Schema::dropIfExists('user_meetings');
    }
}
