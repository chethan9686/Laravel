<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeAmountAttachment extends Model
{
    protected $fillable = [
        'user_id', 
        'year',      
        'April',
        'May',
        'June',
        'July',
        'Agust',
        'September',
        'October',
        'November',
        'December',
        'January',
        'February',
        'March',
        'April_Status',
        'May_Status',
        'June_Status',
        'July_Status',
        'Agust_Status',
        'September_Status',
        'October_Status',
        'November_Status',
        'December_Status',
        'January_Status',
        'February_Status',
        'March_Status',
        'April_Comment',
        'May_Comment',
        'June_Comment',
        'July_Comment',
        'Agust_Comment',
        'September_Comment',
        'October_Comment',
        'November_Comment',
        'December_Comment',
        'January_Comment',
        'February_Comment',
        'March_Comment'
    ];
}
