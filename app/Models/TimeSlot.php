<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{

    use HasFactory;

    protected $fillable = ['time_value', 'time_unit'];

    public function videoPackages()
    {
        return $this->hasMany(VideoPkg::class, 'time');
    }

}
