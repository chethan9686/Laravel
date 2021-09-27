<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
     protected $fillable = [
        'user_id','id_proof','aadhar','pan','exp_letter','salary_slip','bank_stat','sslc','puc','graduate','post_graduate','other_qualification','certificate_course'
    ];
}
