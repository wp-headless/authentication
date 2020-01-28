<?php

namespace WPHeadless\Auth;

use DateInterval;
use Firebase\JWT\JWT;
use WPHeadless\Auth\Services\Keys;

class Auth
{
    public static function refreshTokensExpireIn(): DateInterval
    {
        $interval = Config::get('REFRESH_TOKEN_EXPIRES', 'P1Y');

        return new DateInterval($interval);
    }

    public static function accessTokensExpireIn(): DateInterval
    {
        $interval = Config::get('ACCESS_TOKEN_EXPIRES', 'P1Y');

        return new DateInterval($interval);
    }
    
    public static function decode(string $token): array
    {
        $publicKey = Keys::getKey('public');

        return (array) JWT::decode($token, $publicKey, ['RS256']);
    }
}
