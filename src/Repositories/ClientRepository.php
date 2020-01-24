<?php

namespace WPHeadless\Auth\Repositories;

use WPHeadless\Auth\Models\Client;
use WPHeadless\Auth\Services\PasswordClient;
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
        // As we are only using "password grant clients" 
        // no need to check $clientIdentifier or $grantType

        // Mitigates timing attacks
        return hash_equals(PasswordClient::getSecret(), (string) $clientSecret);
    }

    private static function getClientName(): string
    {
        return PasswordClient::getName();
    }
}
