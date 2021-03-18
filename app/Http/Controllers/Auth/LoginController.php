<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends ApiController
{
 
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $user = User::where('email', $request->email)->first();

        if(!Hash::check($request->password, optional($user)->password))
        {
            throw  ValidationException::withMessages([
                'email' => [__('auth.failed')]
            ]);
            
        }
        
        return response()->json([
            'plain-text-token' => $user->createToken($request->email)->plainTextToken
        ]);
    }
}
