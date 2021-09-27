<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessSignupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_signups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->integer('parent_id')->nullable(); 
            $table->integer('branch')->default(0); 
            $table->unsignedInteger('tl')->default(0);
            $table->unsignedInteger('rm')->default(0);
            $table->unsignedInteger('rh')->default(0);
            $table->string('company_status')->nullable();
            $table->string('company_name')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_mobile')->nullable();
            $table->string('event_name')->nullable();
            $table->string('event_city')->nullable();
            $table->string('event_startdate')->nullable();
            $table->string('event_enddate')->nullable();
            $table->string('event_billeddate')->nullable();
            $table->string('service')->nullable();
            $table->string('budget_amount')->nullable();
            $table->string('estimate_amount')->nullable();
            $table->string('creative_amount')->nullable();
            $table->longText('budget_sheet')->nullable();
            $table->string('profit_amount')->nullable();
            $table->string('profit_percentage')->nullable();
            $table->string('actual_budget_amount')->nullable();
            $table->string('actual_estimate_amount')->nullable();
            $table->string('actual_profit_amount')->nullable();
            $table->string('actual_profit_percentage')->nullable();
            $table->string('payment_budget_amount')->nullable();
            $table->string('payment_estimate_amount')->nullable();
            $table->string('payment_profit_amount')->nullable();
            $table->string('payment_profit_percentage')->nullable();
            $table->string('advance_payment_status')->nullable();
            $table->string('advance_payment_date')->nullable();
            $table->string('advance_payment_amount')->nullable();
            $table->string('purchase_status')->nullable();
            $table->longText('purchase_file')->nullable();
            $table->string('client_approval_status')->nullable();
            $table->longText('client_approval_file')->nullable();
            $table->string('payment_contract')->nullable();
            $table->string('budget_made_by')->nullable();
            $table->string('event_signed_up')->nullable();
            $table->text('production_employee')->nullable();
            $table->text('creative_employee')->nullable();
            $table->text('outside_employee')->nullable();
            $table->string('status')->default('Pending');
            $table->text('comment')->nullable();
            $table->string('reply')->nullable();
            $table->integer('level')->default(0);
            $table->integer('child')->default(0);
            $table->timestamps();
        });

        Schema::table('business_signups', function (Blueprint $table){
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
        Schema::dropIfExists('business_signups');
    }
}
