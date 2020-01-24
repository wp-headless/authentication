<?php

namespace Tests\Unit\Services\Keys;

use Illuminate\Support\Str;
use WPHeadless\Auth\Services\Keys;

class KeyPairTest extends \Tests\TestCase
{
    public function test_it_can_genrate_key_files()
    {
        $service = new Keys;

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
}
