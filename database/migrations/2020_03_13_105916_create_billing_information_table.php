<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_information', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('signup_id');
            $table->string('signup_splitid')->nullable();
            $table->integer('branch')->default(0); 
            $table->unsignedInteger('tl')->default(0);
            $table->unsignedInteger('rm')->default(0);
            $table->unsignedInteger('rh')->default(0);
            $table->string('bs_number')->nullable();
            $table->longText('purchase_file')->nullable();
            $table->text('po_address')->nullable();
            $table->longText('client_approval_file')->nullable();
            $table->longText('final_invoice_file')->nullable();
            $table->string('company_status')->nullable();
            $table->longText('gst_certificate')->nullable();
            $table->text('single_separate_billing')->nullable();
            $table->string('status')->default('Pending');
            $table->text('comment')->nullable();
            $table->integer('level')->default(0);
            $table->timestamps();
        });
        
        Schema::table('billing_information', function (Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');    
            $table->foreign('signup_id')->references('id')->on('business_signups');                      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_information');
    }
}
