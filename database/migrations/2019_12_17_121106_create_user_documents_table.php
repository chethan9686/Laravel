<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id'); 
            $table->string('id_proof')->default('user/id_proof/default.png');  
            $table->string('aadhar')->default('user/aadhar_card/default.png');
            $table->string('pan')->default('user/pan_card/default.png');
            $table->string('exp_letter')->default('user/experience_letter/default.png');
            $table->string('salary_slip')->default('user/salary_slip/default.png');
            $table->string('bank_stat')->default('user/bank_statement/default.png');
            $table->string('sslc')->default('user/sslc/default.png');
            $table->string('puc')->default('user/puc/default.png');
            $table->string('graduate')->default('user/graduate/default.png');
            $table->string('post_graduate')->default('user/post_graduate/default.png');
            $table->string('other_qualification')->default('user/other_qualification/default.png');
            $table->string('certificate_course')->default('user/certificate_course/default.png');     
            $table->timestamps();
        });

        Schema::table('user_documents', function (Blueprint $table){
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
        Schema::dropIfExists('user_documents');
    }
}
