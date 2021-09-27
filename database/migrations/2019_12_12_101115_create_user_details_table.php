<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('tl')->default(0);
            $table->unsignedInteger('rm')->default(0);
            $table->unsignedInteger('rh')->default(0);
            $table->string('profile_picture')->default('user/profilepicture/default.jpg');
            $table->string('signature')->default('user/signature/default.jpg');
            $table->string('emp_id',50)->nullable();
            $table->string('ref_emp_id',50)->nullable();            
            $table->timestamp('dob')->nullable();
            $table->timestamp('doj')->nullable();
            $table->string('emergency_phone',150)->nullable();
            $table->string('business_phone',150)->nullable();
            $table->string('father_name',150)->nullable();
            $table->string('mother_name',150)->nullable();
            $table->string('occupation',100)->nullable();
            $table->string('marital_status',50)->nullable();
            $table->timestamp('marriage_date')->nullable();
            $table->string('spouse_name',150)->nullable();
            $table->string('designation',150)->nullable();
            $table->string('department',150)->nullable();
            $table->string('work_location',150)->nullable();
            $table->string('blood_group',50)->nullable();
            $table->string('local_addr')->nullable();
            $table->string('permanent_addr')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->timestamps();
        });

        Schema::table('user_details', function (Blueprint $table){
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
        Schema::dropIfExists('user_details');
    }
}
