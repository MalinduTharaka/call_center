<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertiserWork extends Model
{
    protected $table = 'advertiser_works';

    protected $fillable = [
        'user_id', 
        'add_count',
        'complete_time',
        'off_time',
        'ot',
        'date',
        'target',
        'wte_add_count',
    ];
}
