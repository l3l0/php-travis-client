<?php

namespace Travis\Client\Listener;

use Buzz\Listener\ListenerInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;

class TokenAuthListener implements ListenerInterface
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function preSend(RequestInterface $request)
    {
        $request->addHeader('Authorization: token ' . $this->token);
    }

    public function postSend(RequestInterface $request, MessageInterface $response)
    {
    }
}
