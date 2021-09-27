<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOtherDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_other_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id'); 
            $table->text('career_objective')->nullable();
            $table->text('growth_plan')->nullable();
            $table->text('expectation')->nullable();
            $table->text('strength')->nullable();
            $table->text('improvement')->nullable();
            $table->text('future_study')->nullable();
            $table->text('sports')->nullable();
            $table->text('social_activity')->nullable();
            $table->text('hobby')->nullable();
            $table->text('awards')->nullable();
            $table->string('disability',100)->nullable();
            $table->string('contact1_name')->nullable();
            $table->string('contact1_phone')->nullable();
            $table->text('contact1_address')->nullable();
            $table->string('contact2_name')->nullable();
            $table->string('contact2_phone')->nullable();
            $table->text('contact2_address')->nullable();
            $table->string('reference1_name')->nullable();
            $table->string('reference1_company')->nullable();
            $table->string('reference1_phone')->nullable();
            $table->string('reference1_email')->nullable();
            $table->string('reference2_name')->nullable();
            $table->string('reference2_company')->nullable();
            $table->string('reference2_phone')->nullable();
            $table->string('reference2_email')->nullable();          
            $table->timestamps();
        });

        Schema::table('user_other_details', function (Blueprint $table){
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
        Schema::dropIfExists('user_other_details');
    }
}
