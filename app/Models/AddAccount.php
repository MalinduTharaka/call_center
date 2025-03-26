<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddAccount extends Model
{
    use HasFactory;

    protected $table = 'add_accounts';

    protected $fillable = ['name', 'code', 'email', 'phone', 'password'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        dd($this->getTable()); // Debugging table name
    }
}
