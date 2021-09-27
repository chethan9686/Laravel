<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('mom_id');
            $table->unsignedInteger('parent_mom_id');
            $table->string('company_name')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_email')->nullable();
            $table->string('alternate_client_name')->nullable();
            $table->string('alternate_client_email')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('location')->nullable();
            $table->text('bcc_email')->nullable(); 
            $table->text('extra_email')->nullable(); 
            $table->string('person_involved')->nullable();
            $table->string('from_client')->nullable();
            $table->string('from_agency')->nullable();
            $table->longText('key_points')->nullable();
            $table->string('mobile')->nullable();
            $table->string('landline')->nullable();
            $table->text('address_1')->nullable(); 
            $table->text('address_2')->nullable(); 
            $table->text('address_3')->nullable(); 
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        Schema::table('clients', function (Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');  
            $table->foreign('mom_id')->references('id')->on('user_meetings');  
            $table->foreign('parent_mom_id')->references('id')->on('user_meetings');           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
