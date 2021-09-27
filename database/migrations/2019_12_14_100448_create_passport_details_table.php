<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passport_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('user_details_id');
            $table->string('passport_no')->nullable();
            $table->string('issued_at')->nullable();
            $table->timestamp('issued_on')->nullable();
            $table->timestamp('expiry_on')->nullable();
            $table->timestamps();
        });

        Schema::table('passport_details', function (Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_details_id')->references('id')->on('user_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passport_details');
    }
}
