<?php

namespace WPHeadless\JWTAuth;

class JWTAuth
{
    public static function keyPath(string $fileName): string
    {
        return JWT_AUTH_PLUGIN_PATH . '/' . $fileName;
    }
}
