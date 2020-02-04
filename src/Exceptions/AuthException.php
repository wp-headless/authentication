<?php

namespace WPHeadless\Auth\Exceptions;

use Exception;
use WP_REST_Response;

class AuthException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'oAuth exception';

    /**
     * @var string
     */
    protected $code = 'oauth_error';    

    /**
     * @var int
     */
    protected $statusCode = 500;   
    
    public function __construct(string $message = null, int $statusCode = null)
    {
        if ($message) {
            $this->message = $message;
        }

        if ($statusCode) {
            $this->statusCode = $statusCode;
        }        
    }

    public function generateHttpResponse(): WP_REST_Response
    {
        $data = [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
        ];

        return new WP_REST_Response($data, $this->statusCode);        
    }
}
