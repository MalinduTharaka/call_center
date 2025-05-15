<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundOtherOrder extends Model
{
    use HasFactory;

    protected $table = 'refund_other_orders';

    protected $fillable = [
        'order_id',
        'invoice_id',
        'date',
        'name',
        'cro',
        'contact',
        'work_type',
        'reason',
        'amount',
        'advance',
    ];

    protected $casts = [
        'date' => 'datetime',
        'amount' => 'decimal:2',
        'advance' => 'decimal:2',
    ];
}
