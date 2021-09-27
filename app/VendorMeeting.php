<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorMeeting extends Model
{
     protected $fillable = [
        'user_id',
        'tl',
        'rm',
        'rh',
        'branch',
        'references_id',
        'vendor_name',
        'vendor_eventname',
        'location',
        'vendor_dateofmeeting',
        'vendor_time',
        'vendor_purpose'
    ];
}
