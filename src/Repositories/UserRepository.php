<?php

namespace WPHeadless\Auth\Repositories;

use WPHeadless\Auth\Models\User;
use WPHeadless\Auth\Exceptions\InvalidCredentials;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param string $username
     * @param string $password
     * @param string $grantType
     * @param ClientEntityInterface $clientEntity
     * @return UserEntityInterface|null
     */
    public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity)
    {
        $user = wp_authenticate($username, $password);

        if (is_wp_error($user)) {
            throw new InvalidCredentials;
        }

        return new User($user);
    }
}
