<?php

namespace WPHeadless\JWTAuth;

use WPHeadless\JWTAuth\Services\Keys;
use WPHeadless\JWTAuth\Services\Database;
use WPHeadless\JWTAuth\Services\PasswordClient;

class Plugin
{
    /**
     * @var Keys
     */
    protected $keys;

    /**
     * @var Database
     */    
    protected $database;
    
    /**
     * @var PasswordClient
     */    
    protected $passwordClient;      

    public function __construct(Keys $keys, Database $database, PasswordClient $passwordClient)
    {
        $this->keys = $keys;

        $this->database = $database;

        $this->passwordClient = $passwordClient;

        register_activation_hook(JWT_AUTH_PLUGIN, [$this, 'activate']);

        register_deactivation_hook(JWT_AUTH_PLUGIN, [$this, 'deactivate']);
    }

    public function activate(): void
    {
        $this->keys->generate();

        $this->database->install();

        $this->passwordClient->createSecret();
    }

    public function deactivate(): void
    {
        $this->keys->destroy();

        $this->database->uninstall();

        $this->passwordClient->destroySecret();
    }    
}
