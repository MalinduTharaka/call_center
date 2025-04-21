<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'date',
        'inv',
        'contact',
        'order_id1',
        'order_id2',
        'order_id3',
        'total',
        'status',
        'due_date',
        'notifi_status',
        'amt1',
        'amt2',
        'amt3',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
