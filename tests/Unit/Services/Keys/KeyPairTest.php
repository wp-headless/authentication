<?php

namespace Tests\Unit\Services\Keys;

use Tests\ResetsPlugin;
use Illuminate\Support\Str;
use WPHeadless\Auth\Services\Keys;

class KeyPairTest extends \Tests\TestCase
{
    use ResetsPlugin;

    public function test_it_can_genrate_key_files()
    {
        $service = new Keys;

        $service->destroy(); // destroy current

        $service->generate();    
        
        $publicKey = file_get_contents(Keys::keyPath('public'));

        $this->assertTrue(
            Str::contains($publicKey, '-----BEGIN PUBLIC KEY-----')
        );             

        $privateKey = file_get_contents(Keys::keyPath('private'));

        $this->assertTrue(
            Str::contains($privateKey, '-----BEGIN RSA PRIVATE KEY-----')
        );     
        
        unlink(Keys::keyPath('public'));
        unlink(Keys::keyPath('private'));         
    }

    public function test_it_can_destroy_key_files()
    {
        $service = new Keys;

        $service->generate();      

        $this->assertTrue(file_exists(Keys::keyPath('private')));

        $this->assertTrue(file_exists(Keys::keyPath('public')));

        $service->destroy();
        
        $this->assertFalse(file_exists(Keys::keyPath('private')));

        $this->assertFalse(file_exists(Keys::keyPath('public')));
    }    

    public function test_it_can_get_key_from_env()
    {
        putenv('OAUTH_PRIVATE_KEY=foo-private');
        putenv('OAUTH_PUBLIC_KEY=foo-public');

        $service = new Keys;

        $service->generate();      

        $this->assertEquals(Keys::getKey('private'), 'foo-private');
        $this->assertEquals(Keys::getKey('public'), 'foo-public');

        // reset
        unlink(Keys::keyPath('public'));
        unlink(Keys::keyPath('private'));
        putenv('OAUTH_PRIVATE_KEY=');
        putenv('OAUTH_PUBLIC_KEY=');        
    }      
    
    public function test_it_can_get_key_from_file()
    {
        $service = new Keys;

        $service->generate();      

        $this->assertEquals(Keys::getKey('public'), 'file:///var/www/oauth-public.key');

        $this->assertEquals(Keys::getKey('private'), 'file:///var/www/oauth-private.key');

        unlink(Keys::keyPath('public'));
        unlink(Keys::keyPath('private'));
    }         
}
