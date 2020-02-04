<?php

namespace Tests;

use Mockery;
use WP_REST_Server;
use WP_Test_REST_TestCase;

abstract class RestTestCase extends WP_Test_REST_TestCase
{
    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }
}
