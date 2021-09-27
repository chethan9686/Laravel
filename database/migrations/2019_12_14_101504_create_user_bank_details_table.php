<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bank_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('user_details_id');
            $table->unsignedInteger('passport_details_id');
            $table->string('acc_holder_name')->nullable();
            $table->string('acc_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_ifsc')->nullable();
            $table->string('bank_branch')->nullable();    
            $table->string('bank_division')->nullable();   
            $table->timestamps();
        });

        Schema::table('user_bank_details', function (Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_details_id')->references('id')->on('user_details');
            $table->foreign('passport_details_id')->references('id')->on('passport_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_bank_details');
    }
}
