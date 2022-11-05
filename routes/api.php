<?php

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', function () {
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

    $cookie = cookie("access_token", $jwt, 30, '/', config('auth.front_end_top_level_domain'), true, true, false, 'None');

    return response()->json('success', 200)->withCookie($cookie);
});


Route::get('/auth-protected-route', function () {
    return response()->json(
        [
            'message' => 'authenticated successfuly',
            'user' => jwtUser()
        ],
        200
    );
})->middleware('jwt.auth');
