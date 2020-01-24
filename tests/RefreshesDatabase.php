<?php

namespace Tests;

use WPHeadless\Auth\Services\Database;

trait RefreshesDatabase
{
    public function setUp()
    {
        parent::setUp();

        (new Database)->install();
    }

    public function tearDown()
    {
        parent::tearDown();

        (new Database)->uninstall();
    }
}