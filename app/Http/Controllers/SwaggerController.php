<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;

class SwaggerController extends Controller
{
    public function login(): JsonResponse
    {
        $authenticated = auth()->attempt(
            [
                'email' => request()->email,
                'password' => request()->password,
            ]
        );

        if (!$authenticated) {
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
