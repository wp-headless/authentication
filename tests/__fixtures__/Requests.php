<?php

namespace Tests\Fixtures;

use WP_REST_Request;
use WP_REST_Response;

class Requests
{
    public static function accessToken(string $username, string $password): WP_REST_Response
    {
        $request = new WP_REST_Request('POST', "/oauth/v1/token");

        $request->set_param('username', $username);

        $request->set_param('password', $password);

        return rest_get_server()->dispatch($request);           
    }
}