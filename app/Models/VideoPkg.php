<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPkg extends Model
{
    use HasFactory;

    protected $table = 'video_pkgs';

    protected $fillable = [
        'amount',
        'time',
        'type',
    ];

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class, 'time');
    }
}
