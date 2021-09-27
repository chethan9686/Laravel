<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('job_id');
			$table->string('process_id');
			$table->string('process');
			$table->string('required',100);
			$table->string('status',50);
            $table->timestamps();
        });
		
		Schema::table('processes', function (Blueprint $table){
            $table->foreign('job_id')->references('id')->on('qrcodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processes');
    }
}
