<?php

namespace spec\Http\Discovery\Stub;

use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PSR18ClientStub implements HttpClient
{
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
    }
}
