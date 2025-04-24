<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignPayment extends Model
{
    protected $fillable = [
        'work_type_id',
        'amount',
    ];

   
}
