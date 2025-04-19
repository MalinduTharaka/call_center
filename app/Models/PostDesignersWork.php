<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostDesignersWork extends Model
{
    protected $table = 'post_designers_works';

    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'month',
    ];
}
