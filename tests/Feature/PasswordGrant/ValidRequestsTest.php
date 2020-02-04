<?php

namespace Tests\Feature\PasswordGrant;

use DateTime;
use WP_REST_Request;
use Tests\ResetsPlugin;
use Tests\Fixtures;
use WPHeadless\Auth\Auth;
use WPHeadless\Auth\Services\Keys;

class ValidRequestsTest extends \Tests\TestCase
{
    use ResetsPlugin;

    public function test_it_returns_a_valid_token_response()
    {
        Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
        ]);        

        $response = Fixtures\Requests::accessToken('test.user@wp.org', 'secret'); 

        $data = $response->get_data();

        $this->assertEquals($response->status, 200);

        $this->assertEquals($data->token_type, 'Bearer');

        $this->assertTrue(is_int($data->expires_in));

        $this->assertTrue(is_string($data->access_token));

        $this->assertTrue(strlen($data->access_token) > 20);

        $this->assertTrue(is_string($data->refresh_token));

        $this->assertTrue(strlen($data->refresh_token) > 20);

    }

    public function test_it_can_accepts_usernames()
    {
        Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
        ]);  

        $response = Fixtures\Requests::accessToken('test.user', 'secret'); 

        $this->assertEquals($response->status, 200);
    }

    public function test_it_can_accepts_emails()
    {
        Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
        ]);

        $response = Fixtures\Requests::accessToken('test.user@wp.org', 'secret');

        $this->assertEquals($response->status, 200);
    }

    public function test_it_returns_a_valid_token_expiration()
    {
        Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
        ]);

        $response = Fixtures\Requests::accessToken('test.user', 'secret');

        $expctedDT = (new DateTime)->add(Auth::accessTokensExpireIn());

        $expectedTTL = $expctedDT->getTimestamp() - time();

        $this->assertEquals($response->get_data()->expires_in, $expectedTTL);
    }

    public function test_it_can_accept_keys_from_env_variables()
    {
        putenv('OAUTH_PRIVATE_KEY=' . Fixtures\Keys::get('private'));

        putenv('OAUTH_PUBLIC_KEY=' . Fixtures\Keys::get('public'));

        Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
        ]);

        $response = Fixtures\Requests::accessToken('test.user', 'secret');

        $this->assertEquals($response->status, 200);

        $this->assertEquals(Keys::getKey('public'), Fixtures\Keys::get('public'));
    }

    public function test_it_can_access_protected_routes()
    {
        Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
            'role' => 'administrator'
        ]);

        $jwt = Fixtures\Requests::accessToken('test.user@wp.org', 'secret')
            ->get_data()
            ->access_token;

        $request = new WP_REST_Request('POST', "/wp/v2/posts");

        $request->set_header('Authorization', "Bearer $jwt");

        $request->set_body_params([
            'title' => 'Test post 1',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing...',
        ]);

        $response = rest_get_server()->dispatch($request);

        $this->assertEquals($response->status, 201);

        $postId = (int) $response->get_data()['id'];

        $post = get_post($postId);

        $this->assertEquals($post->post_title, 'Test post 1');

        $this->assertEquals($post->post_content, 'Lorem ipsum dolor sit amet, consectetur adipiscing...');
    }
}
