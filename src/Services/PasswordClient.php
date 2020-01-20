<?php

namespace WPHeadless\JWTAuth\Services;

use Illuminate\Support\Str;

class PasswordClient
{
    /**
     * @var string
     */
    protected static $key = '__pgc_secret';

    public function createSecret(): void
    {
        $secret = Str::random(40);

        update_option(static::$key, $secret);
    }

    public function getSecret(): string
    {
        return get_option(static::$key, '');
    }    

    public function destroySecret(): void
    {
        delete_option(static::$key);
    }    

    public function getName(): string
    {
        return get_bloginfo('name');
    }    
}
