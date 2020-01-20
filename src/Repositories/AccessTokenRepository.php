<?php

namespace WPHeadless\JWTAuth\Repositories;

use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;

class AccessTokenRepositoryextends implements AccessTokenRepositoryInterface
{
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null): AccessTokenEntityInterface
    {
        
    }

    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity): void
    {
    }

    public function revokeAccessToken($tokenId): void
    {
    }

    public function isAccessTokenRevoked($tokenId): bool
    {
    }
}
