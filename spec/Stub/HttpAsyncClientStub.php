<?php

namespace spec\Http\Discovery\Stub;

use Http\Client\HttpAsyncClient;
use Psr\Http\Message\RequestInterface;

class HttpAsyncClientStub implements HttpAsyncClient
{
    public function sendAsyncRequest(RequestInterface $request)
    {
    }
}
