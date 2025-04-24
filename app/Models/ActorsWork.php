<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActorsWork extends Model
{
    use HasFactory;
    protected $table = 'actors_works';

    protected $fillable = ['user_id', 'work_type', 'note', 'amount', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
