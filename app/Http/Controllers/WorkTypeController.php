<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkType;

class WorkTypeController extends Controller
{
    public function index(){
        $worktypes = WorkType::all();
        return view('admin.work-type', compact('worktypes'));
    }
}
