<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends ApiController
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, optional($user)->password)) {
            throw  ValidationException::withMessages([
                'email' => [__('auth.failed')]
            ]);
        }

        $token = Str::random(60);
        $user->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return ['token' => $token];
    }

    public function logout()
    {
        try {
            $user = User::where('api_token', Auth::user()->api_token)->first();

            $user->forceFill([
                'api_token' => null,
            ])->save();

            return [
                'message' => 'Sesión cerrada con éxito'
            ];
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
