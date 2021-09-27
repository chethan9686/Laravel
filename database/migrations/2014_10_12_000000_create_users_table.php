<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable(); 
            $table->integer('branch')->default(0); 
            $table->string('email')->unique(); 
            $table->string('phone')->nullable();  
            $table->integer('user_position')->default(0);   
            $table->integer('admin')->default(0);            
            $table->string('status')->default('inactive'); 
            $table->integer('confirm_status')->default(0); 
            $table->integer('leave_status')->default(0);
            $table->integer('block_status')->default(0);
            $table->integer('email_verify')->default(0);
            $table->string('confirmation_code')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
