<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
     protected $fillable = [
        'user_id','mom_id','parent_mom_id','company_name','client_name','client_email','alternate_client_name','alternate_client_email','date','time','location','extra_email','person_involved','from_client','from_agency','key_points','mobile','landline','address_1','address_2','address_3','state','city','zipcode','status','bcc_email'
    ];
}
