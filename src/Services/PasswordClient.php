<?php

namespace WPHeadless\Auth\Services;

use Illuminate\Support\Str;

class PasswordClient
{
    /**
     * @var string
     */
    protected static $key = 'wp-headless:auth:pwc';

    public static function getSecret(): ?string
    {
        return get_option(static::$key, null);
    }       

    public function createSecret(): void
    {
        $secret = Str::random(40);

        update_option(static::$key, $secret);
    } 

    public function destroySecret(): void
    {
        delete_option(static::$key);
    }    

    public static function getName(): string
    {
        return get_bloginfo('name');
    }    
}
