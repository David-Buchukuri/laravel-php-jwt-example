<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\JsonResponse;

class JwtAuth
{
    public function handle(Request $request, Closure $next): JsonResponse | Closure
    {
        try {
            if (request()->cookie('access_token')) {
                $token = request()->cookie('access_token');
            }

            // swagger-ui doesn't support cookies so, if the request is made
            // from swagger, we take access token from auth headers
            if (request()->header('Authorization') > 7) {
                $token = substr(request()->header('Authorization'), 7);
            }

            if (!isset($token)) {
                return response()->json(["message" => "token not present"], 401);
            }

            $decoded = JWT::decode(
                $token,
                new Key(
                    config('auth.jwt_secret'),
                    'HS256'
                )
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
