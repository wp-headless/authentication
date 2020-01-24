<?php

namespace WPHeadless\Auth\Repositories;

use WPHeadless\Auth\Models\Scope;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

class ScopeRepository implements ScopeRepositoryInterface
{
    /**
     * @param string $identifier The scope identifier
     * @return ScopeEntityInterface|null
     */
    public function getScopeEntityByIdentifier($scopeIdentifier)
    {
        return null;
    }

    /**
     * @param ScopeEntityInterface[] $scopes
     * @param string $grantType
     * @param ClientEntityInterface $clientEntity
     * @param null|string $userIdentifier
     * @return ScopeEntityInterface[]
     */
    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null)
    {
        return [];
    }
}
