<?php

namespace WPHeadless\Auth\Exceptions;

class InvalidCredentials extends AuthException
{
    /**
     * @var string
     */
    protected $message = 'Invalid user credentials';

    /**
     * @var string
     */
    protected $code = 'invalid_credentials';    

    /**
     * @var int
     */
    protected $statusCode = 401;       
}
