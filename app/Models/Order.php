<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_type',
        'date',
        'ce',
        'name',
        'contact',
        'cro',
        'work_type',
        'page',
        'work_status',
        'payment_status',
        'cash',
        'advertiser_id',
        'package_amt',
        'service',
        'tax',
        'amount',
        'advance',
        'details',
        'add_acc',
        'our_amount',
        'script',
        'shoot',
        'designer_id',
        'invoice',
        'due_date',
        'user_id',
        'old_new',
        'add_acc_id',
        'fb_fee',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
        'cash' => 'decimal:2',
        'amount' => 'decimal:2',
        'advance' => 'decimal:2',
        'our_amount' => 'decimal:2'
    ];

    /**
     * Get the package associated with the order.
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Get the user who created the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Add any additional methods or scopes here
}