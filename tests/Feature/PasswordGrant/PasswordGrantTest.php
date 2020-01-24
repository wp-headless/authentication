<?php

namespace Tests\Feature\PasswordGrant;

use WP_REST_Request;
use Tests\RestTestCase;
use Tests\ActivatesPlugin;
use WPHeadless\Auth\Services\PasswordClient;

class PasswordGrantTest extends RestTestCase
{
    use ActivatesPlugin;

    public function test_it_issues_access_tokens()
    {
        wp_insert_user([
            'user_login' => 'barak.obama',
            'user_email' => 'barak.obama@usa.gov',
            'user_pass' => 'secret',
            'role' => 'administrator',
        ]);

        $request = new WP_REST_Request('POST', "/oauth/v1/tokens");

        $params = [
            'grant_type' => 'password',
            'client_id' => '',
            'client_secret' => PasswordClient::getSecret(),
            'scope' => '',
            'username' => 'barak.obama@usa.gov',
            'password' => 'secret',
        ];

        foreach ($params as $key => $value) {
            $request->set_param($key, $value);
        }

        $response = rest_get_server()->dispatch($request);
    }
}
