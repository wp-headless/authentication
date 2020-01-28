<?php

namespace WPHeadless\Auth\Services;

use WPHeadless\Auth\Config;
use Illuminate\Support\Arr;
use phpseclib\Crypt\RSA;

class Keys
{
    /**
     * @var RSA
     */
    protected $rsa;

    /**
     * @var string
     */
    protected static $encryptionKeyStore = 'wp-headless:auth:key';

    public function __construct()
    {
        $this->rsa = new RSA;
    }

    public static function getKey(string $type): string
    {
        $configKey = strtoupper($type) . '_KEY';

        $filePath = 'file://' . static::keyPath($type);

        return Config::get($configKey, $filePath);
    }

    public static function keyPath(string $type): string
    {
        return WPH_AUTH_PLUGIN_PATH . '/' . 'oauth-'.$type.'.key';
    }

    public static function getEncryptionKey(): string
    {
        return get_option(static::$encryptionKeyStore, '');
    }    

    public function generate(): void
    {
        $this->generateKeyPair();

        $this->generateEncryptionKey();
    }

    public function destroy(): void
    {
        unlink(static::keyPath('public'));

        unlink(static::keyPath('private'));  

        delete_option(static::$encryptionKeyStore);
    }    

    protected function generateKeyPair(): void
    {
        $keys = $this->rsa->createKey(4096);

        file_put_contents(static::keyPath('public'), Arr::get($keys, 'publickey'));

        file_put_contents(static::keyPath('private'), Arr::get($keys, 'privatekey'));
    }    

    protected function generateEncryptionKey(): void
    {
        $key = base64_encode(random_bytes(32));

        update_option(static::$encryptionKeyStore, $key);
    }
}
