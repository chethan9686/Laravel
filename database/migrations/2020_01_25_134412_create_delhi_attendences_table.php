<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelhiAttendencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delhi_attendences', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('emp_id',100)->nullable();    
            $table->string('emp_name',100)->nullable();
            $table->string('year',100)->nullable();    
            $table->string('month',100)->nullable();
            $table->string('one',100)->nullable();
            $table->string('two',100)->nullable();
            $table->string('three',100)->nullable();
            $table->string('four',100)->nullable();
            $table->string('five',100)->nullable();
            $table->string('six',100)->nullable();
            $table->string('seven',100)->nullable();
            $table->string('eight',100)->nullable();
            $table->string('nine',100)->nullable();
            $table->string('ten',100)->nullable();
            $table->string('eleven',100)->nullable();
            $table->string('twelve',100)->nullable();
            $table->string('thirteen',100)->nullable();
            $table->string('fourteen',100)->nullable();
            $table->string('fifteen',100)->nullable();
            $table->string('sixteen',100)->nullable();
            $table->string('seventeen',100)->nullable();
            $table->string('eighteen',100)->nullable();
            $table->string('nineteen',100)->nullable();
            $table->string('twenty',100)->nullable();
            $table->string('twentyone',100)->nullable();
            $table->string('twentytwo',100)->nullable();
            $table->string('twentythree',100)->nullable();
            $table->string('twentyfour',100)->nullable();
            $table->string('twentyfive',100)->nullable();
            $table->string('twentysix',100)->nullable();
            $table->string('twentyseven',100)->nullable();
            $table->string('twentyeight',100)->nullable();
            $table->string('twentynine',100)->nullable();
            $table->string('thirty',100)->nullable();
            $table->string('thirtyone',100)->nullable();
            $table->float('present', 8, 2)->nullable();
            $table->float('meeting', 8, 2)->nullable();
            $table->float('event', 8, 2)->nullable();
            $table->float('outstation', 8, 2)->nullable();
            $table->float('comp', 8, 2)->nullable();
            $table->float('paid_leave', 8, 2)->nullable();
            $table->float('cut_leave', 8, 2)->nullable();
            $table->float('working', 8, 2)->nullable();     
            $table->timestamps();
        });

        Schema::table('delhi_attendences', function (Blueprint $table){
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
        Schema::dropIfExists('delhi_attendences');
    }
}
