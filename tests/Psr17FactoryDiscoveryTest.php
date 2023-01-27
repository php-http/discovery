<?php

namespace tests\Http\Discovery;

use Http\Discovery\Exception\NotFoundException;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

class Psr17FactoryDiscoveryTest extends TestCase
{
    /**
     * @dataProvider getFactories
     */
    public function testFind($method, $interface)
    {
        if (!interface_exists(RequestFactoryInterface::class)) {
            $this->markTestSkipped(RequestFactoryInterface::class.' required.');
        }

        $callable = [Psr17FactoryDiscovery::class, $method];
        $client = $callable();
        $this->assertInstanceOf($interface, $client);
    }

    /**
     * @group NothingInstalled
     * @dataProvider getFactories
     */
    public function testNotFound($method)
    {
        $callable = [Psr17FactoryDiscovery::class, $method];
        $this->expectException(NotFoundException::class);
        $callable();
    }

    public function getFactories()
    {
        yield ['findRequestFactory', RequestFactoryInterface::class];
        yield ['findResponseFactory', ResponseFactoryInterface::class];
        yield ['findServerRequestFactory', ServerRequestFactoryInterface::class];
        yield ['findStreamFactory', StreamFactoryInterface::class];
        yield ['findUploadedFileFactory', UploadedFileFactoryInterface::class];
        yield ['findUriFactory', UriFactoryInterface::class];
        yield ['findUrlFactory', UriFactoryInterface::class];
    }
}
