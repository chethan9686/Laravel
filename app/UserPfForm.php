<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPfForm extends Model
{
     protected $fillable = [
        'user_id','user_details_id','passport_details_id','bank_details_id','pf_name','pf_dob','pf_doj','pf_acc_no','pf_bank_name','pf_bank_ifsc','pf_phone','pf_aadhar','pf_pan','father_name'
        ,'father_age','father_dob','father_aadhar','mother_name','mother_age','mother_dob','mother_aadhar','husb_or_wife_name','husb_or_wife_dob','husb_or_wife_aadhar','son_name','son_dob'
        ,'son_aadhar','daughter_name','daughter_dob','daughter_aadhar','nominee_name','nominee_relt','dispensary','permt_addr','temp_addr'
    ];
}
