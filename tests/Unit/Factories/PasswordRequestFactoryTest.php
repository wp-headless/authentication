<?php

namespace Tests\Unit\Factories;

use WP_REST_Request;
use WPHeadless\Auth\Services\PasswordClient;
use WPRestApi\PSR7\WP_REST_PSR7_ServerRequest;
use WPHeadless\Auth\Factories\PasswordRequest;

class PasswordRequestFactoryTest extends \Tests\TestCase
{
    public function test_it_returns_a_psr_request()
    {
        $factory = new PasswordRequest;

        $request = $factory->create(new WP_REST_Request);

        $this->assertInstanceOf(WP_REST_PSR7_ServerRequest::class, $request);
    }

    public function test_it_sets_passowrd_grant_attributes()
    {
        $request = new WP_REST_Request;

        $this->assertNull($request->get_param('client_id'));
        $this->assertNull($request->get_param('grant_type'));
        $this->assertNull($request->get_param('client_secret'));

        $request = (new PasswordRequest)->create($request);

        $this->assertEquals($request->get_param('client_id'), '');
        $this->assertEquals($request->get_param('grant_type'), 'password');
        $this->assertEquals($request->get_param('client_secret'), PasswordClient::getSecret());
    }   
    
    public function test_it_overrides_passowrd_grant_attributes()
    {
        $request = new WP_REST_Request;

        $request->set_param('client_id', 'foo-bar');
        $request->set_param('grant_type', 'foo-bar');
        $request->set_param('client_secret', 'foo-bar');

        $request = (new PasswordRequest)->create($request);

        $this->assertEquals($request->get_param('client_id'), '');
        $this->assertEquals($request->get_param('grant_type'), 'password');
        $this->assertEquals($request->get_param('client_secret'), PasswordClient::getSecret());
    }     
}
