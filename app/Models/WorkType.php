<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkType extends Model
{
    use HasFactory;

    protected $table = 'work_types';

    protected $fillable = ['name', 'order_type'];

    public function designPayment()
    {
        return $this->hasOne(\App\Models\DesignPayment::class, 'work_type_id');
    }
}
