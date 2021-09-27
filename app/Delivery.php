<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    //
     protected $fillable = [
        'user_id',
        'tl',
        'rm',
        'rh',
        'branch',
        'delry_clientname',
	    'delry_lcation',
	    'delry_dateofdelivery',
	    'delry_time',
	    'purposeofdelivery',
	    'itemdescription',
	    'delry_ERTW',
        'delivery_references_id'
    ];
}
