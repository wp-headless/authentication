<?php

namespace WPHeadless\JWTAuth\Repositories;

use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    /**
     * @return RefreshTokenEntityInterface|null
     */
    public function getNewRefreshToken()
    {

    }

    /**
     * @param RefreshTokenEntityInterface $refreshTokenEntity
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {

    }

    /**
     * @param string $tokenId
     */
    public function revokeRefreshToken($tokenId)
    {

    }

    /**
     * @param string $tokenId
     * @return bool Return true if this token has been revoked
     */
    public function isRefreshTokenRevoked($tokenId)
    {

    }
}
