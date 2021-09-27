<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBusinessRevionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_business_revions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->integer('branch')->default(0); 
            $table->unsignedInteger('tl')->default(0);
            $table->unsignedInteger('rm')->default(0);
            $table->unsignedInteger('rh')->default(0);
            $table->unsignedInteger('signup_id');
            $table->unsignedInteger('biilling_id');
            $table->string('bs_number')->nullable();
            $table->string('revision')->nullable();
            $table->string('invoice_no')->nullable();
            $table->text('revision_reason')->nullable();
            $table->integer('status')->default('0');
            $table->text('comment')->nullable();
            $table->integer('level')->default('0');
            $table->timestamps();
        });

        Schema::table('user_business_revions', function (Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');    
            $table->foreign('signup_id')->references('id')->on('business_signups');                      
            $table->foreign('biilling_id')->references('id')->on('billing_information');                      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_business_revions');
    }
}
