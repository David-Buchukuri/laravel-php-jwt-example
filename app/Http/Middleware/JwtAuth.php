<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtAuth
{
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!request()->cookie('access_token')) {
                return response()->json(["message" => "token not present"], 401);
            }
            $decoded = JWT::decode(
                request()->cookie('access_token'),
                new Key(config('auth.jwt_secret'), 'HS256')
            );

            if ($decoded->validTill > Carbon::now()->timestamp) {
                return $next($request);
            }

            return response()->json(["message" => "token expired"], 401);
        } catch (Exception $e) {
            return response()->json(["message" => "couldn't verify the token"], 401);
        }
    }
}
