<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BangaloreAttendence extends Model
{
    protected $fillable = [
        'user_id','emp_id','emp_name','year','month','one','two','three','four','five','six','seven','eight','nine','ten',
        'eleven','twelve','thirteen','fourteen','fifteen','sixteen','seventeen','eighteen','nineteen','twenty','twentyone',
        'twentytwo','twentythree','twentyfour','twentyfive','twentysix','twentyseven','twentyeight','twentynine','thirty',
        'thirtyone','present','meeting','event','outstation','comp','paid_leave','cut_leave','working'
    ];
}
