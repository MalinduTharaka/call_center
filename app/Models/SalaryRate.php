<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryRate extends Model
{
    use HasFactory;
    protected $table = 'salary_rates';

    protected $fillable = [
        'role',
        'basic',
        'allowance',
        'b_bonus',
        'v_bonus',
        'ad_bonus',
        'at_bonus',
        'ot',
        'transport',
    ];
}
