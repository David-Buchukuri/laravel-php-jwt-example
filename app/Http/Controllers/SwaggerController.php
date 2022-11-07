<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;

class SwaggerController extends Controller
{
    public function login()
    {
        $autheticated = auth()->attempt(
            [
                'email' => request()->email,
                'password' => request()->password,
            ]
        );

        if (!$autheticated) {
            return response()->json('wrong email or password', 401);
        }

        $payload = [
            'validTill' => Carbon::now()->addMinutes(30)->timestamp,
            'userId' => User::where('email', '=', request()->email)->first()->id,
        ];

        $jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');

        return response()->json(['access_token' => $jwt], 200);
    }
}
