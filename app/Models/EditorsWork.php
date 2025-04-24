<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorsWork extends Model
{
    use HasFactory;
    protected $table = 'editors_works';

    protected $fillable = [
        'user_id',
        'work_type',
        'duration',
        'amount',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
