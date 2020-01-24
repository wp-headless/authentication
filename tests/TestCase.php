<?php

namespace Tests;

use Mockery;
use WP_UnitTestCase;

abstract class TestCase extends WP_UnitTestCase
{
    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }
}
