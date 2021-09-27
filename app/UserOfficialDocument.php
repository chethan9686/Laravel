<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOfficialDocument extends Model
{
     protected $fillable = [
        'user_id','kra','commitment','offer_letter','yearly_appraisal'
    ];
}
