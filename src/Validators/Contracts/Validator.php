<?php

namespace WPHeadless\Auth\Validators\Contracts;

use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use League\OAuth2\Server\AuthorizationValidators\AuthorizationValidatorInterface;

interface Validator extends AuthorizationValidatorInterface
{
    public function determineCurrentUser($result, WP_REST_Server $server, WP_REST_Request $request): ?WP_REST_Response;
}
