<?php

namespace WPHeadless\Auth\Factories;

use WP_REST_Request;
use WPHeadless\Auth\Services\PasswordClient;
use WPRestApi\PSR7\WP_REST_PSR7_ServerRequest;

class RefreshRequest
{
    public function create(WP_REST_Request $request): WP_REST_PSR7_ServerRequest
    {
        $request->set_param('client_id', '');

        $request->set_param('client_secret', PasswordClient::getSecret());

        $request->set_param('grant_type', 'refresh_token');

        return WP_REST_PSR7_ServerRequest::fromRequest($request);         
    }
}