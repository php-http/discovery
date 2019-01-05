<?php

namespace tests\Http\Discovery;

use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\HeaderAppendPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpAsyncClient;
use Http\Client\Promise\HttpFulfilledPromise;
use Http\Discovery\Exception\DiscoveryFailedException;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Promise\Promise;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Psr18ClientDiscoveryTest extends TestCase
{
    public function testFind()
    {
        $client = Psr18ClientDiscovery::find();
        $this->assertInstanceOf(ClientInterface::class, $client);
    }

    /**
     * @group NothingInstalled
     */
    public function testNotFound()
    {
        $this->expectException(DiscoveryFailedException::class);
        $client = Psr18ClientDiscovery::find();
    }
}
