<?php

namespace WPHeadless\JWTAuth\Repositories;

use WPHeadless\JWTAuth\Models\Client;
use WPHeadless\JWTAuth\Services\PasswordClient;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @param string $clientIdentifier
     * @return ClientEntityInterface|null
     */
    public function getClientEntity($clientIdentifier)
    {
        $client = new Client;

        $client->setIdentifier($clientIdentifier);

        $client->setName(static::getClientName());

        return $client;
    }

    /**
     * @param string      $clientIdentifier
     * @param null|string $clientSecret
     * @param null|string $grantType
     * @return bool
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        $passwordClient = new PasswordClient;

        // As we are only using "password grant clients" 
        // no need to check $clientIdentifier or $grantType

        // Mitigates timing attacks
        return hash_equals($passwordClient->getSecret(), (string) $clientSecret);
    }

    private static function getClientName(): string
    {
        return get_bloginfo('name');
    }
}
