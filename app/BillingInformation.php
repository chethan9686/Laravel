<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingInformation extends Model
{
    //
    protected $fillable = [
        'id',
        'user_id',
        'branch',
        'tl',
        'rm',
        'rh',
        'bs_number',
        'signup_id',
        'signup_splitid',
        'purchase_file',
        'po_address',
        'client_approval_file',
        'final_invoice_file',
        'company_status',
        'gst_certificate',
        'single_separate_billing',
        'level',	
        'status',
        'comment'
    ];
}
