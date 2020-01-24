<?php

namespace WPHeadless\Auth;

use DateInterval;

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
}
