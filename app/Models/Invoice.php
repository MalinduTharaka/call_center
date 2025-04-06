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
        'date',
        'inv',
        'contact',
        'order_id1',
        'order_id2',
        'order_id3',
        'total',
        'status',
        'due_date',
        'amt1',
        'amt2',
        'amt3',
    ];
}
