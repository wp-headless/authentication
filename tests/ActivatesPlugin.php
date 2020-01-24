<?php

namespace Tests;

trait ActivatesPlugin
{
    public function setUp()
    {
        parent::setUp();

        jwtAuth()->activate();
    }

    public function tearDown()
    {
        parent::tearDown();

        jwtAuth()->deactivate();
    }   
}