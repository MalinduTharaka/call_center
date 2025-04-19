<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salaries';

    protected $fillable = [
        'user_id',
        'month',
        'basic',
        'allowance',
        'bonus',
        'ot',
        'transport',
        'leave',
        'late',
        'attendace_bonus',
        'deduction',
        'net_salary',
    ];
}
