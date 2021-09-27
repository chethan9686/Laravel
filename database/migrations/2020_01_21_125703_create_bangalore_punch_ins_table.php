<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBangalorePunchInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bangalore_punch_ins', function (Blueprint $table) {
            $table->increments('id');          
            $table->string('emp_id',100)->nullable();            
            $table->string('card_id',100)->nullable();
            $table->string('emp_name',100)->nullable();
            $table->string('date',100)->nullable();
            $table->string('time',100)->nullable();
            $table->string('gate',100)->nullable();
            $table->string('punch_details',100)->nullable();
            $table->string('location',100)->nullable();
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
        Schema::dropIfExists('bangalore_punch_ins');
    }
}
