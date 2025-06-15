<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NetIncome extends Model
{
    /**
     * The table associated with the model.
     *
     * (Laravel would guess “net_incomes” automatically, but making it
     * explicit avoids surprises if you ever rename things.)
     */
    protected $table = 'net_incomes';

    /**
     * Mass-assignable attributes.
     */
    protected $fillable = [
        'month',
        'service',
        'designs',
        'video',
        'other',
        'salary',
        'act_payment',
        'dsg_payment',
        'vde_payment',
        'water_bill',
        'ecb_bill',
        'int_bill',
        'rent',
        'other_business',
        'other_deductions',
        'net_income',
    ];
}
