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
        'uid',
        'work_type_id',
        'page',
        'work_status',
        'payment_status',
        'cash',
        'advertiser_id',
        'package_amt',
        'service',
        'tax',
        'amount',
        'video_time',
        'advance',
        'details',
        'add_acc',
        'our_amount',
        'script',
        'shoot',
        'editor_id',
        'designer_id',
        'd_img',
        'invoice',
        'due_date',
        'user_id',
        'old_new',
        'add_acc_id',
        'fb_fee',
        'ps',
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
    public function workType()
    {
        return $this->belongsTo(WorkType::class, 'work_type_id');
    }
    public function croUser()
    {
        return $this->belongsTo(CallCenter::class, 'cro');
    }
    public function plUser()
    {
        return $this->belongsTo(User::class, 'uid');
    }
    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }
    public function Editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
    public function Designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    // Add any additional methods or scopes here
}