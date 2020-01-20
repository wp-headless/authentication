<?php

namespace Tests\Services;

use Illuminate\Support\Str;
use WPHeadless\JWTAuth\Services\Keys;

class KeysTest extends \Tests\TestCase
{
    public function test_it_returns_key_paths()
    {
        $paths = Keys::getKeyPaths();

        $this->assertEquals($paths['public'], '/var/www/oauth-public.key');

        $this->assertEquals($paths['private'], '/var/www/oauth-private.key');
    }

    public function test_it_can_genrate_key_files()
    {
        $service = new Keys;

        $paths = $service->generate();    
        
        $publicKey = file_get_contents($paths['public']);

        $this->assertTrue(
            Str::contains($publicKey, '-----BEGIN PUBLIC KEY-----')
        );             

        $privateKey = file_get_contents($paths['private']);

        $this->assertTrue(
            Str::contains($privateKey, '-----BEGIN RSA PRIVATE KEY-----')
        );     
        
        unlink($paths['public']);

        unlink($paths['private']);         
    }

    public function test_it_can_destroy_key_files()
    {
        $service = new Keys;

        $paths = $service->generate();      

        $this->assertTrue(file_exists($paths['private']));

        $this->assertTrue(file_exists($paths['public']));

        $service->destroy();
        
        $this->assertFalse(file_exists($paths['private']));

        $this->assertFalse(file_exists($paths['public']));
    }    
}
