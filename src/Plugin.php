<?php

namespace WPHeadless\Auth;

use WP_Error;
use WP_REST_Server;
use WPHeadless\Auth\Services\Keys;
use WPHeadless\Auth\Services\Database;
use WPHeadless\Auth\Services\PasswordClient;
use WPHeadless\Auth\Validators\BearerTokenValidator;
use WPHeadless\Auth\Http\Controllers;

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

    /**
     * @var array
     */
    protected $validators = [
        Validators\BearerTokenValidator::class
    ];    

    public function __construct(Keys $keys, Database $database, PasswordClient $passwordClient)
    {
        $this->keys = $keys;

        $this->database = $database;

        $this->passwordClient = $passwordClient;

        register_activation_hook(WPH_AUTH_PLUGIN, [$this, 'activate']);

        register_deactivation_hook(WPH_AUTH_PLUGIN, [$this, 'deactivate']);

        add_action('rest_api_init', [$this, 'registerControllers']);

        $this->initValidators();
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

    public function reset(): void
    {
        $this->keys->destroy();

        $this->passwordClient->destroySecret();

        $this->keys->generate();

        $this->passwordClient->createSecret();        
    }     

    public function registerControllers(): void
    {
        (new Controllers\PasswordGrantController)->register();

        (new Controllers\RefreshGrantController)->register();
    }

    public function initValidators(): void
    {
        foreach ($this->validators as $class) {

            $validator = new $class;

            add_filter('rest_pre_dispatch', [$validator, 'determineCurrentUser'], 10, 3);
        }
    }
}
