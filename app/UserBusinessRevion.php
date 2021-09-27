<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBusinessRevion extends Model
{
    //
    protected $fillable = [
        'id',
        'user_id',
        'branch',
        'tl',
        'rm',
        'rh',
        'signup_id',
        'biilling_id',
        'bs_number',
        'revision',
        'invoice_no',
        'revision_reason',
        'status',
        'comment','level'
    ];
}
