<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(): JsonResponse
    {
        User::create([
            'email' => request()->email,
            'password'  => bcrypt(request()->password),
            'name'  => request()->name
        ]);

        return response()->json(['message' => 'user created successfully'], 201);
    }

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

        $cookie = cookie("access_token", $jwt, 30, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

        return response()->json('success', 200)->withCookie($cookie);
    }

    public function logout(): JsonResponse
    {
        $cookie = cookie("access_token", '', 0, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

        return response()->json('success', 200)->withCookie($cookie);
    }

    public function me(): JsonResponse
    {
        return response()->json(
            [
                'message' => 'authenticated successfully',
                'user' => jwtUser()
            ],
            200
        );
    }
}
