<?php

namespace tests\Http\Discovery;

use Http\Discovery\Exception\NotFoundException;
use Http\Discovery\Psr18ClientDiscovery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

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
        $this->expectException(NotFoundException::class);
        $client = Psr18ClientDiscovery::find();
    }
}
