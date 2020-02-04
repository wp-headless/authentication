<?php

namespace Tests\Unit\Validators;

use Tests\Fixtures;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WPHeadless\Auth\Services\Keys;
use WPHeadless\Auth\Validators\BearerTokenValidator;

class BearerTokenValidatorTest extends \Tests\TestCase
{
    public function test_it_does_not_validate_oauth_routes()
    {
        $server = new WP_REST_Server;

        $validator = new BearerTokenValidator;

        $request = new WP_REST_Request('POST', '/oauth/v1/token');

        $this->assertNull(
            $validator->determineCurrentUser(null, $server, $request)
        );

        $request = new WP_REST_Request('POST', '/oauth/v1/foo/bar');

        $this->assertNull(
            $validator->determineCurrentUser(null, $server, $request)
        );        
    }

    public function test_it_sets_correct_user()
    {
        $this->assertEquals(wp_get_current_user()->ID, 0);

        $userId = Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
        ]);        

        $jwt = Fixtures\Requests::accessToken('test.user@wp.org', 'secret')
            ->get_data()
            ->access_token; 

        $server = new WP_REST_Server;

        $validator = new BearerTokenValidator;

        $request = new WP_REST_Request('POST', "/wp/v2/posts");

        $request->set_header('Authorization', "Bearer $jwt");
        
        $validator->determineCurrentUser(null, $server, $request);

        $this->assertEquals(wp_get_current_user()->ID, $userId);
    } 
    
    public function test_it_returns_HTTP_error_on_server_exceptions()
    {
        $invalidJwt = 'GsphbMwhHqdHuraRr53srphbMwhHqdHuraRrf9e';

        $server = new WP_REST_Server;

        $validator = new BearerTokenValidator;

        $request = new WP_REST_Request('POST', "/wp/v2/posts");

        $request->set_header('Authorization', "Bearer $invalidJwt");
        
        $response = $validator->determineCurrentUser(null, $server, $request);

        $this->assertEquals($response->get_data()['code'], 'access_denied');

        $this->assertEquals($response->get_status(), 401);
    }       

    public function test_it_throws_on_general_exceptions()
    {
        $invalidJwt = 'GsphbMwhHqdHuraRr53G';

        $server = new WP_REST_Server;

        $validator = new BearerTokenValidator;

        $keysService = new Keys;

        $keysService->destroy();

        $request = new WP_REST_Request('POST', "/wp/v2/posts");

        $request->set_header('Authorization', "Bearer $invalidJwt");
        
        $response = $validator->determineCurrentUser(null, $server, $request);

        $this->assertInstanceOf(WP_REST_Response::class, $response);

        $this->assertEquals($response->get_data()['code'], 'oauth_exception');

        $this->assertEquals($response->get_status(), 500);

        $keysService->generate();
    }           
}
