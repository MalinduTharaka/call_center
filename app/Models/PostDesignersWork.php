<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostDesignersWork extends Model
{
    use HasFactory;
    protected $table = 'post_designers_works';

    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'month',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class);
    }

}
