<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppriciationwishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appriciationwishes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('appriciationmail_id');    
            $table->string('name');                          
            $table->text('appriciation_whishes');
            $table->timestamps();
        });
        
        Schema::table('appriciationwishes', function (Blueprint $table){               
            $table->foreign('appriciationmail_id')->references('id')->on('appriciations');     
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appriciationwishes');
    }
}
