<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';
    
    protected $fillable = [
        'full',
        'package_amount',
        'tax',
        'service',
        'our_amount'
    ];

    protected $casts = [
        'package_amount' => 'decimal:2',
        'tax' => 'decimal:2',
        'our_amount' => 'decimal:2'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}