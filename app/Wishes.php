<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishes extends Model
{
    protected $fillable = [
        'user_id',
        'tl',
        'rm',
        'rh',
        'branch',
        'comment',
        'level'
    ];
}
