<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessSignup extends Model
{
    protected $fillable = [
        'id','user_id','branch','tl','rm','rh','company_status','company_name','client_name','client_email','client_mobile','event_name','event_city','event_startdate','event_enddate','event_billeddate','budget_amount','estimate_amount','creative_amount','budget_sheet','profit_amount','profit_percentage','advance_payment_status','advance_payment_date','advance_payment_amount','purchase_status','purchase_file','client_approval_status','client_approval_file','payment_contract','budget_made_by','event_signed_up','level','status','comment','production_employee','creative_employee','outside_employee','parent_id','child','actual_budget_amount','actual_estimate_amount','actual_profit_amount','actual_profit_percentage','payment_budget_amount','payment_estimate_amount','payment_profit_amount','payment_profit_percentage','service','reply'
    ];
}
