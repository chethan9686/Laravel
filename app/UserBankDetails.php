<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBankDetails extends Model
{
    protected $fillable = [
        'user_id','user_details_id','passport_details_id','acc_holder_name','acc_no','bank_name','bank_ifsc','bank_branch','bank_division'
    ];
}
