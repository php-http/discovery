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
        if (!interface_exists(ClientInterface::class)) {
            $this->markTestSkipped(ClientInterface::class.' required.');
        }

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
