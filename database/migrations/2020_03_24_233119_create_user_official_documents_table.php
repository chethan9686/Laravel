<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOfficialDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_official_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id'); 
            $table->string('kra')->default('user/kra/default.png');  
            $table->string('commitment')->default('user/commitment/default.png');  
            $table->string('offer_letter')->default('user/offer_letter/default.png');
            $table->string('yearly_appraisal')->default('user/yearly_appraisal/default.png');
            $table->timestamps();
        });

        Schema::table('user_official_documents', function (Blueprint $table){
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
        Schema::dropIfExists('user_official_documents');
    }
}
