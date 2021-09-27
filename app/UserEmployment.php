<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEmployment extends Model
{
      protected $fillable = [
        'user_id','duration_from','duration_to','duration_month','organization','designation','role','leaving'
    ];
}
