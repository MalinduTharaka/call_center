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
        'advertiser_id_new',
        'add_acc_id_new',
        'upsheet_uid',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }

    public function advertiserNew()
    {
        return $this->belongsTo(User::class, 'advertiser_id_new');
    }

    public function plUser()
    {
        return $this->belongsTo(User::class, 'cro');
    }

    public function workType()
    {
        return $this->belongsTo(WorkType::class, 'work_type');
    }
}
