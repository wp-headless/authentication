<?php

namespace WPHeadless\Auth;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;
use WPHeadless\Auth\Repositories;
use League\OAuth2\Server\CryptKey;
use WPHeadless\Auth\Services\Keys;

class ServerFactory
{
    public function makeAuthorizationServer(): AuthorizationServer
    {
        $server = $this->initServer();

        $grant = $this->makePasswordGrant();

        $server->enableGrantType($grant, Auth::accessTokensExpireIn());

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

    protected function initServer(): AuthorizationServer
    {
        $encryptionKey = Keys::getEncryptionKey();

        $clientRepo = new Repositories\ClientRepository;

        $accessTokenRepo = new Repositories\AccessTokenRepository;

        $scopeRepo = new Repositories\ScopeRepository;

        $privateKey = $this->makeCryptKey('private');

        $server = new AuthorizationServer($clientRepo, $accessTokenRepo, $scopeRepo, $privateKey, $encryptionKey);

        return $server;
    }

    protected function makeCryptKey(string $type): CryptKey
    {
        $configKey = strtoupper($type) . '_KEY';

        $filePath = 'file://' . Keys::keyPath($type);

        $key = Config::get($configKey, $filePath);

        return new CryptKey($key, null, false);
    }
}
