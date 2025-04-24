<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
        protected $fillable = [
        'target',
        'user_role',
        'target_type',
        'target_category',
    ];
}
