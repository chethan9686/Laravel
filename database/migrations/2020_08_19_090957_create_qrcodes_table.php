<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('job');
			$table->string('cust');
			$table->unsignedInteger('quantity');   
			$table->string('repeat_of',150);
			$table->string('release_date',150);		
			$table->string('disc',150);
			$table->string('released_by',150);	
			$table->string('socket',150);
			$table->string('type',150);
			$table->string('solder',150);
			$table->string('flux',150);
			$table->string('note',150);
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
        Schema::dropIfExists('qrcodes');
    }
}
