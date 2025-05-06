<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class OutsideAuthController extends Controller
{
    public function index(){
        return view('outside-auth.outside-login');
    }

    public function verifyEmail(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email']
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'No account found with that email.'
            ], 404);
        }

        // only allow these roles
        if (! in_array($user->role, ['dsg','vde','act'])) {
            return response()->json([
                'status'  => 'error',
                'message' => 'You are not authorized to log in here.'
            ], 403);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }
}
