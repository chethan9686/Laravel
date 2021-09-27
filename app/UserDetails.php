<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
     protected $fillable = [
        'user_id','tl','rm','rh','profile_picture','signature','emp_id','ref_emp_id','dob','doj','emergency_phone','business_phone','father_name'
        ,'mother_name','occupation','marital_status','marriage_date','spouse_name','designation','department','work_location','blood_group','local_addr','permanent_addr','city','state','pincode'
    ];
}
