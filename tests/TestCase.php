<?php

namespace Tests;

use Mockery;

abstract class TestCase extends \WP_UnitTestCase
{
    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }
}
