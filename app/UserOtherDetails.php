<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOtherDetails extends Model
{
    protected $fillable = [
        'user_id','career_objective','growth_plan','expectation','strength','improvement','future_study','sports','social_activity','hobby','awards','disability','contact1_name','contact1_phone','contact1_address','contact2_name','contact2_phone','contact2_address','reference1_name','reference1_company','reference1_phone','reference1_email','reference2_name','reference2_company','reference2_phone','reference2_email'
    ];
}
