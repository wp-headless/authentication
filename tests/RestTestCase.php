<?php

namespace Tests;

use Mockery;

abstract class RestTestCase extends \WP_Test_REST_TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        
        Mockery::close();
    }  
}