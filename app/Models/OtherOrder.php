<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherOrder extends Model // Use singular for convention
{
    protected $table = 'other_orders'; // optional if class is named correctly

    protected $fillable = [
        'date', 'ce', 'user_id', 'cc_id', 'invoice_id',
        'name', 'contact', 'work_type', 'note',
        'work_status', 'payment_status', 'cash',
        'amount', 'advance', 'ps'
    ];

    // Example relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function callCenter()
    {
        return $this->belongsTo(CallCenter::class, 'cc_id');
    }
}
