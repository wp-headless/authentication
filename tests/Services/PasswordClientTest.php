<?php

namespace Tests\Services;

use WPHeadless\JWTAuth\Services\PasswordClient;

class PasswordClientTest extends \Tests\TestCase
{
    public function test_it_creates_a_secret()
    {
        $service = new PasswordClient;

        $service->createSecret();

        $secret = $service->getSecret();

        $this->assertTrue(is_string($secret));

        $this->assertEquals(strlen($secret), 40);
    }

    public function test_it_destroys_the_secret()
    {
        $service = new PasswordClient;

        $service->createSecret();

        $service->destroySecret();

        $secret = $service->getSecret();

        $this->assertEmpty($secret);
    }       
    
    public function test_it_has_a_name()
    {
        $service = new PasswordClient;

        $this->assertEquals($service->getName(), get_bloginfo('name'));
    }     
}