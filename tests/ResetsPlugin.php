<?php

namespace Tests;

trait ResetsPlugin
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();

        oAuth()->reset();

        putenv('OAUTH_ACCESS_TOKEN_EXPIRES');

        putenv('OAUTH_REFRESH_TOKEN_EXPIRES');

        putenv('OAUTH_PUBLIC_KEY');

        putenv('OAUTH_PRIVATE_KEY');
    }   
}