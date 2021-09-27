<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appriciationwish extends Model
{
     protected $fillable = [
        'name',
        'appriciationmail_id',
        'appriciation_whishes',
    ];
}
