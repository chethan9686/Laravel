<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessSignupSplitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_signup_splits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('signup_id');
            $table->string('employee_id')->nullable();
            $table->string('percentage')->nullable();
            $table->timestamps();
        });

        Schema::table('business_signup_splits', function (Blueprint $table){
            $table->foreign('signup_id')->references('id')->on('business_signups');          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_signup_splits');
    }
}
