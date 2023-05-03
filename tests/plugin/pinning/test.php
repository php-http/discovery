<?php

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

require __DIR__.'/vendor/autoload.php';

class MyClient implements ClientInterface
{
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()->createResponse();
    }
}

echo get_class(Psr17FactoryDiscovery::findRequestFactory());
echo '-', get_class(Psr18ClientDiscovery::find());
echo "\n";
