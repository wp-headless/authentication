<?php

$table_prefix  = 'wp_';

$___WPConfig = [
    /*
    |--------------------------------------------------------------------------
    | Database
    |--------------------------------------------------------------------------
    */
    'DB_NAME' => 'wordpress_tests',
    'DB_USER' => 'root',
    'DB_PASSWORD' => 'secret',
    'DB_HOST' => 'service-database',
    'DB_CHARSET' => 'utf8',
    'DB_COLLATE' => '',

    /*
    |--------------------------------------------------------------------------
    | Wordpress config
    |--------------------------------------------------------------------------
    */
    'FS_METHOD' => 'direct',
    'FS_CHMOD_DIR' => (0775 & ~umask()),
    'FS_CHMOD_FILE' => (0664 & ~umask()),
    'WP_DEBUG' => true,
    'WP_MEMORY_LIMIT' => -1,
    'WP_MAX_MEMORY_LIMIT' => -1,
    'WP_DEFAULT_THEME' => 'default',
    'WP_TESTS_DOMAIN' => 'localhost',
    'WP_TESTS_EMAIL' => 'hello@example.com',
    'WP_TESTS_TITLE' => 'Test Blog',
    'WP_PHP_BINARY' => 'php',
    'DISABLE_WP_CRON' => true,
    'WPLANG' => '',

    /*
    |--------------------------------------------------------------------------
    | Wordpress paths and urls
    |--------------------------------------------------------------------------
    */
    'ABSPATH' => __DIR__.'/../wordpress/',
];


foreach ($___WPConfig as $key => $value) {
    if (!defined($key)) {
        define($key, $value);
    }
}

$_SERVER['HTTPS'] = 'on';

if (false === isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['SERVER_NAME'], $_SERVER['HTTP_HOST'])) {
    $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
    $_SERVER['SERVER_NAME'] = '';
    $_SERVER['HTTP_HOST'] = 'localhost';
}
