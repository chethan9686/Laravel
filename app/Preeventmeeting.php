<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preeventmeeting extends Model
{
    //
     protected $fillable = [
        'user_id',
        'tl',
        'rm',
        'rh',
        'branch',
        'pem_clientname',
        'pem_dateofmeeting',
        'pem_time',
        'pem_eventstartdate',
        'pem_lcation',
        'pem_ERTW',
        'pem_references_id'
    ];
}
