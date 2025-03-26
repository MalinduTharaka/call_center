<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddAccount extends Model
{
    use HasFactory;

    protected $table = 'add_accounts';

    protected $fillable = ['name', 'code', 'email', 'phone', 'password'];

}
