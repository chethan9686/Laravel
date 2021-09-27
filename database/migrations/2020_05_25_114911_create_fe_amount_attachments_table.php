<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeAmountAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fe_amount_attachments', function (Blueprint $table) {            
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');     
            $table->longText('year',100)->nullable();          
            $table->longText('April',100)->nullable(); 
            $table->longText('May',100)->nullable(); 
            $table->longText('June',100)->nullable(); 
            $table->longText('July',100)->nullable(); 
            $table->longText('Agust',100)->nullable(); 
            $table->longText('September',100)->nullable(); 
            $table->longText('October',100)->nullable(); 
            $table->longText('November',100)->nullable(); 
            $table->longText('December',100)->nullable(); 
            $table->longText('January',100)->nullable(); 
            $table->longText('February',100)->nullable(); 
            $table->longText('March',100)->nullable(); 

            $table->string('April_Status',100)->default(0);
            $table->string('May_Status',100)->default(0);
            $table->string('June_Status',100)->default(0);
            $table->string('July_Status',100)->default(0);
            $table->string('Agust_Status',100)->default(0);
            $table->string('September_Status',100)->default(0);
            $table->string('October_Status',100)->default(0);
            $table->string('November_Status',100)->default(0);
            $table->string('December_Status',100)->default(0);
            $table->string('January_Status',100)->default(0);
            $table->string('February_Status',100)->default(0);
            $table->string('March_Status',100)->default(0);

            $table->longText('April_Comment',100)->nullable(); 
            $table->longText('May_Comment',100)->nullable(); 
            $table->longText('June_Comment',100)->nullable(); 
            $table->longText('July_Comment',100)->nullable(); 
            $table->longText('Agust_Comment',100)->nullable(); 
            $table->longText('September_Comment',100)->nullable(); 
            $table->longText('October_Comment',100)->nullable(); 
            $table->longText('November_Comment',100)->nullable(); 
            $table->longText('December_Comment',100)->nullable(); 
            $table->longText('January_Comment',100)->nullable(); 
            $table->longText('February_Comment',100)->nullable(); 
            $table->longText('March_Comment',100)->nullable();
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
        Schema::dropIfExists('fe_amount_attachments');
    }
}
