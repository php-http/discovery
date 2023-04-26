<?php

namespace tests\Http\Discovery;

use Http\Discovery\Psr17Factory;
use Http\Discovery\Psr18Client;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Discovery\Strategy\DiscoveryStrategy;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Psr18ClientTest extends TestCase
{
    protected function setUp(): void
    {
        if (!interface_exists(RequestFactoryInterface::class)) {
            $this->markTestSkipped(RequestFactoryInterface::class.' required.');
        }
        if (!interface_exists(ClientInterface::class)) {
            $this->markTestSkipped(ClientInterface::class.' required.');
        }
    }

    public function testClient()
    {
        $mockClient = new class() implements ClientInterface {
            public $request;
            public $response;

            public function sendRequest(RequestInterface $request): ResponseInterface
            {
                $this->request = $request;

                return $this->response;
            }
        };

        $client = new Psr18Client($mockClient);
        $this->assertInstanceOf(Psr17Factory::class, $client);

        $mockResponse = $client->createResponse();
        $mockClient->response = $mockResponse;

        $request = $client->createRequest('GET', '/foo');
        $this->assertSame($mockResponse, $client->sendRequest($request));
        $this->assertSame($request, $mockClient->request);
    }

    public function testDiscovery()
    {
        $mockClient = new class() implements ClientInterface, DiscoveryStrategy {
            public static $client;

            public $request;
            public $response;

            public function __construct()
            {
                self::$client = $this;
            }

            public function sendRequest(RequestInterface $request): ResponseInterface
            {
                $this->request = $request;

                return $this->response;
            }

            public static function getCandidates($type)
            {
                return is_a(ClientInterface::class, $type, true)
                    ? [['class' => self::class, 'condition' => self::class]]
                    : [];
            }
        };

        Psr18ClientDiscovery::prependStrategy(get_class($mockClient));
        $client = new Psr18Client();

        $this->assertInstanceOf(get_class($mockClient), $mockClient::$client);
        $mockClient = $mockClient::$client;
        $mockResponse = $client->createResponse();
        $mockClient->response = $mockResponse;

        $request = $client->createRequest('GET', '/foo');
        $this->assertSame($mockResponse, $client->sendRequest($request));
        $this->assertSame($request, $mockClient->request);
    }
}
