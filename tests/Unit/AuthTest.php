<?php

namespace Tests\Unit;

use DateInterval;
use Carbon\Carbon;
use WP_REST_Request;
use WPHeadless\Auth\Auth;
use Tests\ActivatesPlugin;
use WPRestApi\PSR7\WP_REST_PSR7_Response;
use WPHeadless\Auth\Factories;
class AuthTest extends \Tests\TestCase
{
    use ActivatesPlugin;

    public function test_it_has_default_refresh_token_expiration()
    {
        $interval = Auth::refreshTokensExpireIn();

        $this->assertEquals($interval, new DateInterval('P1Y'));
    }

    public function test_it_can_set_refresh_token_expiration()
    {
        define('OAUTH_REFRESH_TOKEN_EXPIRES', 'P2Y');

        $interval = Auth::refreshTokensExpireIn();

        $this->assertEquals($interval, new DateInterval('P2Y'));
    }   
    
    public function test_it_has_default_access_token_expiration()
    {
        $interval = Auth::accessTokensExpireIn();

        $this->assertEquals($interval, new DateInterval('P1Y'));
    }

    public function test_it_can_set_access_token_expiration()
    {
        define('OAUTH_ACCESS_TOKEN_EXPIRES', 'P2Y');

        $interval = Auth::accessTokensExpireIn();

        $this->assertEquals($interval, new DateInterval('P2Y'));
    }   
    
    public function test_it_can_decode_a_token()
    {
        $userId = wp_insert_user([
            'user_login' => 'barak.obama',
            'user_email' => 'barak.obama@usa.gov',
            'user_pass' => 'secret',
        ]);

        $request = new WP_REST_Request('POST');

        $request->set_param('username', 'barak.obama@usa.gov');

        $request->set_param('password', 'secret');

        $psrRequest = (new Factories\PasswordRequest)->create($request);

        $server = (new Factories\AuthServer)->create();

        $response = $server->respondToAccessTokenRequest($psrRequest, new WP_REST_PSR7_Response);  
        
        $token = $response->get_data()->access_token;

        $decoded = Auth::decode($token);

        $this->assertEquals($decoded['sub'], $userId);
        $this->assertEquals($decoded['aud'], '');
        $this->assertEquals($decoded['scopes'], []);

        $this->assertTrue(
            Carbon::createFromTimestamp($decoded['exp'])->gte(Carbon::now())
        );

        $this->assertTrue(
            Carbon::createFromTimestamp($decoded['nbf'])->gte(
                Carbon::now()->setMilliseconds(0)
            )
        );        
    }            
}
