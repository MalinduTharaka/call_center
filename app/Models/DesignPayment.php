<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignPayment extends Model
{
    protected $fillable = [
        'work_type_id',
        'amount',
    ];

   public function workType()
   {
    return $this->belongsTo(WorkType::class,'work_type_id');
   }
}
