<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PassportDetails extends Model
{
     protected $fillable = [
        'user_id','user_details_id','passport_no','issued_at','issued_on','expiry_on'
    ];
}
