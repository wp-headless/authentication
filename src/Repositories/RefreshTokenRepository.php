<?php

namespace WPHeadless\Auth\Repositories;

use WPHeadless\Auth\Models\RefreshToken;
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
        return new RefreshToken;
    }

    /**
     * @param RefreshTokenEntityInterface $refreshTokenEntity
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $refreshTokenEntity->save();
    }

    /**
     * @param string $tokenId
     */
    public function revokeRefreshToken($tokenId)
    {
        if ($token = RefreshToken::getById($tokenId)) {
            $token->revoke();
        }          
    }

    /**
     * @param string $tokenId
     * @return bool Return true if this token has been revoked
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        if ($token = RefreshToken::getById($tokenId)) {
            return $token->isRevoked();
        }

        return true;
    }
}
