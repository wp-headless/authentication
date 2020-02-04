<?php

namespace WPHeadless\Auth\Factories;

use WPHeadless\Auth\Auth;
use WPHeadless\Auth\Config;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use WPHeadless\Auth\Repositories;
use League\OAuth2\Server\CryptKey;
use WPHeadless\Auth\Services\Keys;

class AuthServer
{
    public function create(): AuthorizationServer
    {
        $server = $this->initServer();

        $passwordGrant = $this->makePasswordGrant();

        $server->enableGrantType($passwordGrant, Auth::accessTokensExpireIn());

        $refreshTokenGrant = $this->makeRefreshTokenGrant();

        $server->enableGrantType($refreshTokenGrant, Auth::accessTokensExpireIn());        

        return $server;
    }

    protected function makePasswordGrant(): PasswordGrant
    {
        $userRepo = new Repositories\UserRepository;

        $refreshTokenRepo = new Repositories\RefreshTokenRepository;

        $grant = new PasswordGrant($userRepo, $refreshTokenRepo);

        $grant->setRefreshTokenTTL(Auth::refreshTokensExpireIn());

        return $grant;
    }

    protected function makeRefreshTokenGrant(): RefreshTokenGrant
    {
        $refreshTokenRepo = new Repositories\RefreshTokenRepository;

        $grant = new RefreshTokenGrant($refreshTokenRepo);

        $grant->setRefreshTokenTTL(Auth::refreshTokensExpireIn());

        return $grant;
    }    

    protected function initServer(): AuthorizationServer
    {
        $encryptionKey = Keys::getEncryptionKey();

        $clientRepo = new Repositories\ClientRepository;

        $accessTokenRepo = new Repositories\AccessTokenRepository;

        $scopeRepo = new Repositories\ScopeRepository;

        $privateKey = Keys::makeKey('private');

        $server = new AuthorizationServer($clientRepo, $accessTokenRepo, $scopeRepo, $privateKey, $encryptionKey);

        return $server;
    }
}
