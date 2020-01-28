<?php

namespace Tests\Feature\PasswordGrant;

use WP_REST_Request;
use Tests\RestTestCase;
use Tests\ActivatesPlugin;

class PasswordGrantTest extends RestTestCase
{
    use ActivatesPlugin;

    public function test_it_issues_valid_access_tokens()
    {
        wp_insert_user([
            'user_login' => 'barak.obama',
            'user_email' => 'barak.obama@usa.gov',
            'user_pass' => 'secret',
        ]);

        $request = new WP_REST_Request('POST', "/oauth/v1/tokens");

        $request->set_param('username', 'barak.obama@usa.gov');

        $request->set_param('password', 'secret');

        $response = rest_get_server()->dispatch($request);

        
    }
}
