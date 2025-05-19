<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendances';

    protected $fillable = ['user_id', 'date', 'arr_time', 'leave_time'];

    public function User(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
