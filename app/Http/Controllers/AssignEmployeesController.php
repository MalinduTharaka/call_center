<?php

namespace App\Http\Controllers;

use App\Models\User;
class AssignEmployeesController extends Controller
{
    public function index(){
        $users = User::all();
    }
}
