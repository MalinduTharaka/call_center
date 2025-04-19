<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditorsWork extends Model
{
    protected $table = 'editors_works';

    protected $fillable = [
        'user_id',
        'work_type',
        'duration',
        'amount',
        'date',
    ];
}
