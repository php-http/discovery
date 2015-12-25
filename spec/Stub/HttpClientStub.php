<?php

namespace spec\Http\Discovery\Stub;

use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;

class HttpClientStub implements HttpClient
{
    public function sendRequest(RequestInterface $request)
    {
    }
}
