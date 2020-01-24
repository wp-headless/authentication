<?php

/**
 * Plugin Name: JWT Auth
 * Version: 0.1.0
 * Plugin URI: https://github.com/wp-headless/jwt-auth
 * Description: JWT authentication layer for Wordpress REST API
 * Author: Andrew McLagan
 *
 * @package JWT Auth
 * @author Andrew McLagan
 */

if (!defined('ABSPATH')) exit;

define('WPH_AUTH_PLUGIN', __FILE__);
define('WPH_AUTH_PLUGIN_PATH', __DIR__);

require_once __DIR__ . '/vendor/autoload.php';

$keys = new \WPHeadless\Auth\Services\Keys; 

$database = new \WPHeadless\Auth\Services\Database; 

$passwordClient = new \WPHeadless\Auth\Services\PasswordClient; 

$GLOBALS['jwt-auth'] = new \WPHeadless\Auth\Plugin($keys, $database, $passwordClient);

function jwtAuth(): \WPHeadless\Auth\Plugin
{
    return $GLOBALS['jwt-auth'] ?? null;
}
