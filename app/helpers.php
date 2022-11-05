<?php

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function jwtUser()
{
    try {
        $decoded = JWT::decode(
            request()->cookie('access_token'),
            new Key(config('auth.jwt_secret'), 'HS256')
        );

        return User::find($decoded->userId);
    } catch (Exception $e) {
        return null;
    }
}
