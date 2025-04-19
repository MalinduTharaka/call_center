<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActorsWork extends Model
{
    protected $table = 'actors_works';

    protected $fillable = ['user_id', 'work_type', 'note', 'amount', 'date'];
}
