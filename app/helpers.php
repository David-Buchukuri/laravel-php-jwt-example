<?php

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function jwtUser()
{
    try {
        if (!request()->cookie('access_token') && !request()->header('Authorization')) {
            throw new \ErrorException('token is not provided');
        }

        $decoded = JWT::decode(
            request()->cookie('access_token') ?? substr(request()->header('Authorization'), 7),
            new Key(config('auth.jwt_secret'), 'HS256')
        );

        return User::find($decoded->uid);
    } catch (Exception $e) {
        return null;
    }
}
