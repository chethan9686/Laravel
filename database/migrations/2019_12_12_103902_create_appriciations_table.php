<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppriciationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appriciations', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('companyname')->nullable();
            $table->string('clientname')->nullable();
            $table->string('eventname')->nullable();
            $table->timestamp('eventdate')->nullable();
            $table->string('location')->nullable();
            $table->longtext('clientmail')->nullable();
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
        Schema::dropIfExists('appriciations');
    }
}
