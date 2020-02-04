<?php

namespace Tests\Feature\PasswordGrant;

use Carbon\Carbon;
use WP_REST_Request;
use Tests\Fixtures;
use Tests\ResetsPlugin;
use WPHeadless\Auth\Models\AccessToken;
use WPHeadless\Auth\Services\Keys;

class InvalidRequestsTest extends \Tests\TestCase
{
    use ResetsPlugin;

    public function test_it_throws_error_on_invalid_password()
    {
        Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
        ]);

        $response = Fixtures\Requests::accessToken('test.user@wp.org', 'foo-bar-bam');

        $this->assertEquals($response->status, 401);

        $this->assertEquals($response->get_data()['code'], 'invalid_credentials');
    }

    public function test_it_throws_error_on_invalid_username()
    {
        Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
        ]);

        $response = Fixtures\Requests::accessToken('foo-bar-bam', 'secret');

        $this->assertEquals($response->status, 401);

        $this->assertEquals($response->get_data()['code'], 'invalid_credentials');
    }

    public function test_it_throws_error_on_missing_oAuth_keys()
    {
        Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
        ]);

        $keysService = new Keys;

        $keysService->destroy();

        $response = Fixtures\Requests::accessToken('test.user@wp.org', 'foo-bar-bam');

        $this->assertEquals($response->status, 500);

        $this->assertRegexp(
            '/Key path .* does not exist or is not readable/',
            $response->get_data()['message']
        );

        $keysService->generate();
    }

    public function test_it_throws_error_on_missing_oAuth_encryption_secret()
    {
        delete_option('wp-headless:auth:key');

        Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
        ]);

        $response = Fixtures\Requests::accessToken('test.user@wp.org', 'secret');

        $this->assertEquals($response->status, 500);

        $this->assertRegexp(
            '/Encryption key not set when attempting to encrypt/',
            $response->get_data()['message']
        );

        $keysService = new Keys;

        $keysService->destroy();

        $keysService->generate();
    }

    public function test_it_throws_on_invalid_privileges()
    {
        Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
            'role' => 'subscriber'
        ]);

        $jwt = Fixtures\Requests::accessToken('test.user', 'secret')
            ->get_data()
            ->access_token;

        $request = new WP_REST_Request('POST', "/wp/v2/posts");

        $request->set_header('Authorization', "Bearer $jwt");

        $request->set_body_params([
            'title' => 'Test post 2',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing...',
        ]);

        $response = rest_get_server()->dispatch($request);

        $this->assertEquals($response->status, 403);
    }

    public function test_it_throws_error_on_expired_access_token()
    {
        // Tokens expire in one second
        putenv('OAUTH_ACCESS_TOKEN_EXPIRES=PT1S');

        Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
            'role' => 'administrator'
        ]);

        $jwt = Fixtures\Requests::accessToken('test.user', 'secret')
            ->get_data()
            ->access_token;

        // wait for token to expire
        sleep(2);

        $request = new WP_REST_Request('POST', "/wp/v2/posts");

        $request->set_header('Authorization', "Bearer $jwt");

        $request->set_body_params([
            'title' => 'Test post 2',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing...',
        ]);

        $response = rest_get_server()->dispatch($request);

        $this->assertEquals($response->status, 401);

        $this->assertEquals($response->get_data()['code'], 'access_denied');

        $this->assertEquals($response->get_data()['message'], 'Access token is invalid');
    }

    public function test_it_throws_error_on_revoked_access_token()
    {
        $userId = Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
            'role' => 'administrator'
        ]);

        $jwt = Fixtures\Requests::accessToken('test.user', 'secret')
            ->get_data()
            ->access_token;

        $accessToken = AccessToken::getByUserId($userId);

        $accessToken->update([
            'revoked_at' => Carbon::now()
        ]);

        $this->assertTrue($accessToken->fresh()->isRevoked());

        $request = new WP_REST_Request('POST', "/wp/v2/posts");

        $request->set_header('Authorization', "Bearer $jwt");

        $request->set_body_params([
            'title' => 'Test post 2',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing...',
        ]);

        $response = rest_get_server()->dispatch($request);

        $this->assertEquals($response->status, 401);

        $this->assertEquals($response->get_data()['code'], 'access_denied');

        $this->assertEquals($response->get_data()['message'], 'Access token has been revoked');
    }
}
