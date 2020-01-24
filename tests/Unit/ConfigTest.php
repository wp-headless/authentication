<?php

namespace Tests\Unit;

use WPHeadless\Auth\Config;

class ConfigTest extends \Tests\TestCase
{
    public function test_it_returns_constant_vals()
    {
        define('OAUTH_FOO', 'bar');

        $this->assertEquals(Config::get('FOO'), 'bar');
    }

    public function test_it_returns_env_vals()
    {
        putenv('OAUTH_BAR=foo');

        $this->assertEquals(Config::get('BAR'), 'foo');
    }  
    
    public function test_it_constants_override_env_vals()
    {
        define('OAUTH_BAM', '123');

        putenv('OAUTH_BAM=456');

        $this->assertEquals(Config::get('BAM'), '123');
    } 
    
    public function test_it_returns_default_value_when_empty()
    {
        $this->assertEquals(Config::get('SLAM', 'hello-world'), 'hello-world');
    }      
}
