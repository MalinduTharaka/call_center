<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderUpdate extends Model
{
    use HasFactory;

    protected $table = 'order_updates';

    protected $fillable = [
        'order_id',
        'invoice_id',
        'date',
        'name',
        'cro',
        'contact',
        'order_type',
        'work_type',
        'page',
        'work_status',
        'update',
        'advertiser_id',
        'add_acc_id',
        'add_acc',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Optional relationship examples if needed:
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }
}
