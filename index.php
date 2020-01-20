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

define('JWT_AUTH_PLUGIN', __FILE__);
define('JWT_AUTH_PLUGIN_PATH', __DIR__);

require_once __DIR__ . '/vendor/autoload.php';

$keys = new \WPHeadless\JWTAuth\Services\Keys; 

$database = new \WPHeadless\JWTAuth\Services\Database; 

$passwordClient = new \WPHeadless\JWTAuth\Services\PasswordClient; 

$GLOBALS['jwt-auth'] = new \WPHeadless\JWTAuth\Plugin($keys, $database, $passwordClient);

function jwtAuth()
{
    return $GLOBALS['jwt-auth'] ?? null;
}
