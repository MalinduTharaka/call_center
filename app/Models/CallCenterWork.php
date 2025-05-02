<?php

namespace App\Models;

use App\Enums\TargetStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallCenterWork extends Model
{
    use HasFactory;
    protected $table = 'call_center_works';

    protected $fillable = [
        'user_id',
        'order_count',
        'month',
        'complete_date',
        'target_id',
    ];

    protected $casts = [
        'status' => TargetStatusEnum::class,
    ];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
