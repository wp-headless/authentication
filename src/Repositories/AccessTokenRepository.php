<?php

namespace WPHeadless\Auth\Repositories;

use WPHeadless\Auth\Models\AccessToken;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null): AccessTokenEntityInterface
    {
        $accessToken = new AccessToken;

        $accessToken->setUserIdentifier($userIdentifier);

        $accessToken->setClient($clientEntity);

        return $accessToken;
    }

    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity): void
    {
        $accessTokenEntity->save();
    }

    public function revokeAccessToken($tokenId): void
    {
        if ($token = AccessToken::getById($tokenId)) {
            $token->revoke();
        }        
    }

    public function isAccessTokenRevoked($tokenId): bool
    {
        if ($token = AccessToken::getById($tokenId)) {
            return $token->isRevoked();
        }

        return true;
    }
}
