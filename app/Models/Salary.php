<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
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
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
