<?php

namespace WPHeadless\Auth\Validators;

use Exception;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use Illuminate\Support\Str;
use WPRestApi\PSR7\WP_REST_PSR7_ServerRequest;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\AuthorizationValidators\BearerTokenValidator as BaseBearerTokenValidator;
use WPHeadless\Auth\Repositories\AccessTokenRepository;
use WPHeadless\Auth\Validators\Contracts\Validator;
use WPHeadless\Auth\Services\Keys;

class BearerTokenValidator extends BaseBearerTokenValidator implements Validator
{
    public function __construct()
    {
        parent::__construct(new AccessTokenRepository);
    }

    public function determineCurrentUser($result, WP_REST_Server $server, WP_REST_Request $request): ?WP_REST_Response
    {
        if (Str::contains($request->get_route(), 'oauth/v1')) {
            return null; // pass through oauth routes
        }

        try {

            $publicKey = Keys::makeKey('public');

            $this->setPublicKey($publicKey);

            $psrRequest = WP_REST_PSR7_ServerRequest::fromRequest($request);

            $validatedRequest = $this->validateAuthorization($psrRequest);

        } catch (OAuthServerException $exception) {
            return new WP_REST_Response(
                [
                    'message' => $exception->getHint(),
                    'code' =>  $exception->getErrorType()
                ],
                $exception->getHttpStatusCode()
            );
        } catch (Exception $exception) {
            return new WP_REST_Response(
                [
                    'message' => $exception->getMessage(),
                    'code' => 'oauth_exception'
                ],
                500
            );
        }

        $userId = (int) $validatedRequest->getAttribute('oauth_user_id');

        if ($userId) {
            wp_set_current_user($userId);
        }

        return null;
    }
}
