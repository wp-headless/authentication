<?php

namespace WPHeadless\Auth\Http\Controllers;

use WP_REST_Request;
use WP_REST_Response;
use WPRestApi\PSR7\WP_REST_PSR7_ServerRequest;
use WPRestApi\PSR7\WP_REST_PSR7_Response;
use WPHeadless\Auth\ServerFactory;

class AuthorizationController
{
    /**
     * @var string
     */
    protected $namespace = '/oauth/v1';

    /**
     * @var string
     */
    protected $resource = 'tokens';

    /**
     * @var string
     */
    protected $server;

    public function __construct()
    {
        $this->server = (new ServerFactory)->makeAuthorizationServer();
    }

    public function register(): void
    {
        register_rest_route($this->namespace, '/' . $this->resource, [
            [
                'methods'   => 'POST',
                'callback'  => [$this, 'authorize'],
                'permission_callback' => [$this, 'permissions'],
            ],
            'schema' => [$this, 'schema'],
        ]);
    }

    public function permissions(): bool
    {
        return true;
    }

    public function schema(): array
    {
        return [
            '$schema' => 'http://json-schema.org/draft-04/schema#',
            'title' => 'token',
            'type' => 'object',
            'properties' => [
                'token_type' => [
                    'description' => 'Type of token being issued.',
                    'type' => 'string',
                ],
                'expires_in' => [
                    'description' => 'Represents the TTL of the access token.',
                    'type' => 'integer',
                ],
                'access_token' => [
                    'description' => 'A signed JWT used to access protected resources.',
                    'type' => 'string',
                ],
                'refresh_token' => [
                    'description' => 'Encrypted payload that can be used to refresh the access token when it expires.',
                    'type' => 'string',
                ],
            ],
        ];
    }

    public function authorize(WP_REST_Request $request): WP_REST_Response
    {
        $psrRequest = WP_REST_PSR7_ServerRequest::fromRequest($request);

        $response = $this->server->respondToAccessTokenRequest($psrRequest, new WP_REST_PSR7_Response);

        dd($response->get_data()->access_token);
    }
}
