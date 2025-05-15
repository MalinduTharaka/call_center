<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundOrder extends Model
{
    use HasFactory;

    protected $table = 'refund_orders';

    protected $fillable = [
        'order_id',
        'invoice_id',
        'date',
        'name',
        'cro',
        'contact',
        'order_type',
        'work_type',
        'reason',
        'pkg_amt',
        'service',
        'tax',
        'amount',
        'advance',
    ];

    protected $casts = [
        'date' => 'datetime',
        'pkg_amt' => 'decimal:2',
        'service' => 'decimal:2',
        'tax' => 'decimal:2',
        'amount' => 'decimal:2',
        'advance' => 'decimal:2',
    ];

    public function plUser()
    {
        return $this->belongsTo(User::class, 'cro');
    }

    public function workType()
    {
        return $this->belongsTo(WorkType::class, 'work_type');
    }
}
