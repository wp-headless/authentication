<?php

namespace WPHeadless\Auth;

class Config
{
    public static function get(string $key, $default = null): ?string
    {
        $key = 'OAUTH_' . $key;

        if (defined($key)) {
            return constant($key);
        }

        if (getenv($key)) {
            return getenv($key);
        }
        
        return $default;
    }
}
