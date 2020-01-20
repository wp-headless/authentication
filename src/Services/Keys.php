<?php

namespace WPHeadless\JWTAuth\Services;

use Illuminate\Support\Arr;
use WPHeadless\JWTAuth\JWTAuth;
use phpseclib\Crypt\RSA;

class Keys
{
    /**
     * @var RSA
     */
    protected $rsa;

    public function __construct()
    {
        $this->rsa = new RSA;
    }

    public static function getKeyPaths(): array
    {
        return [
            'public' => JWTAuth::keyPath('oauth-public.key'),
            'private' => JWTAuth::keyPath('oauth-private.key'),
        ];
    }

    public function generate(): array
    {
        $paths = static::getKeyPaths();

        $keys = $this->rsa->createKey(4096);

        file_put_contents($paths['public'], Arr::get($keys, 'publickey'));

        file_put_contents($paths['private'], Arr::get($keys, 'privatekey'));

        return $paths;
    }

    public function destroy(): void
    {
        $paths = static::getKeyPaths();

        unlink($paths['public']);

        unlink($paths['private']);  
    }    
}
