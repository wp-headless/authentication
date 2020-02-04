<?php

namespace WPHeadless\Auth\Http\Controllers;

use Exception;
use WP_REST_Request;
use WP_REST_Response;
use WPHeadless\Auth\Exceptions\InvalidCredentials;
use League\OAuth2\Server\Exception\OAuthServerException;
use WPRestApi\PSR7\WP_REST_PSR7_Response;
use WPHeadless\Auth\Factories;

class PasswordGrantController
{
    /**
     * @var string
     */
    protected $namespace = '/oauth/v1';

    /**
     * @var string
     */
    protected $resource = 'token';

    /**
     * @var Factories\ServerFactory
     */
    protected $serverFactory;

    /**
     * @var Factories\PasswordRequest
     */
    protected $requestFactory;

    public function __construct()
    {
        $this->serverFactory = new Factories\AuthServer;

        $this->requestFactory = new Factories\PasswordRequest;
    }

    public function register(): void
    {
        register_rest_route($this->namespace, '/' . $this->resource, [
            [
                'methods'   => 'POST',
                'callback'  => [$this, 'authorize'],
                'args' => [
                    'username' => [
                        'required' => true,
                    ],
                    'password' => [
                        'required' => true,
                    ],
                ],
            ],
            'schema' => [$this, 'schema'],
        ]);
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
        try {

            $server = $this->serverFactory->create();
            
            $psrRequest = $this->requestFactory->create($request);

            $psrResponse = new WP_REST_PSR7_Response;

            $authResponse = $server->respondToAccessTokenRequest(
                $psrRequest,
                $psrResponse
            );
        } catch (InvalidCredentials $exception) {
            $authResponse = $exception->generateHttpResponse(
                $psrResponse
            );
        } catch (OAuthServerException $exception) {
            $authResponse = $exception->generateHttpResponse(
                $psrResponse
            );
        } catch (Exception $exception) {
            $authResponse = new WP_REST_Response(
                [
                    'message' => $exception->getMessage(),
                    'code' => 'oauth_exception'
                ],
                500
            );
        }

        return rest_ensure_response($authResponse);
    }
}
