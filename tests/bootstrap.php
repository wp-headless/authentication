<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

require_once getenv('WP_PHPUNIT__DIR') . '/includes/functions.php';

/**
 * test set up, plugin activation, etc.
 */
tests_add_filter('muplugins_loaded', function () {
    require dirname(__DIR__) . '/index.php';
});

/**
 *  Start up the WP testing environment.
 */
require getenv('WP_PHPUNIT__DIR') . '/includes/bootstrap.php';
