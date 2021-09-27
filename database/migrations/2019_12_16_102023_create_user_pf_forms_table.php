<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPfFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_pf_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('user_details_id');
            $table->unsignedInteger('passport_details_id');
            $table->unsignedInteger('bank_details_id');
            $table->string('pf_name')->nullable();
            $table->timestamp('pf_dob')->nullable();
            $table->timestamp('pf_doj')->nullable();
            $table->string('pf_acc_no')->nullable();
            $table->string('pf_bank_name')->nullable();
            $table->string('pf_bank_ifsc')->nullable();
            $table->string('pf_phone')->nullable();  
            $table->string('pf_aadhar')->nullable();  
            $table->string('pf_pan')->nullable();  
            $table->string('father_name')->nullable();  
            $table->string('father_age',50)->nullable();  
            $table->timestamp('father_dob')->nullable();  
            $table->string('father_aadhar')->nullable();  
            $table->string('mother_name')->nullable();  
            $table->string('mother_age',50)->nullable();  
            $table->timestamp('mother_dob')->nullable();  
            $table->string('mother_aadhar')->nullable();  
            $table->string('husb_or_wife_name')->nullable();  
            $table->timestamp('husb_or_wife_dob')->nullable();  
            $table->string('husb_or_wife_aadhar')->nullable(); 
            $table->string('son_name')->nullable();  
            $table->timestamp('son_dob')->nullable();  
            $table->string('son_aadhar')->nullable(); 
            $table->string('daughter_name')->nullable();  
            $table->timestamp('daughter_dob')->nullable();  
            $table->string('daughter_aadhar')->nullable(); 
            $table->string('nominee_name')->nullable(); 
            $table->string('nominee_relt')->nullable();  
            $table->text('dispensary')->nullable(); 
            $table->text('permt_addr')->nullable();
            $table->text('temp_addr')->nullable();        
            $table->timestamps();
        });

        Schema::table('user_pf_forms', function (Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_details_id')->references('id')->on('user_details');
            $table->foreign('passport_details_id')->references('id')->on('passport_details');
            $table->foreign('bank_details_id')->references('id')->on('user_bank_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_pf_forms');
    }
}
