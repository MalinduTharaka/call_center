<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkType extends Model
{
    use HasFactory;

    protected $table = 'work_types';

    protected $fillable = ['name', 'order_type'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        dd($this->getTable()); // Debugging table name
    }
}
