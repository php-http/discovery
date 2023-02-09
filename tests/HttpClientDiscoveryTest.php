<?php

namespace tests\Http\Discovery;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use PHPUnit\Framework\TestCase;

class HttpClientDiscoveryTest extends TestCase
{
    public function testFind()
    {
        if (!interface_exists(HttpClient::class)) {
            $this->markTestSkipped(HttpClient::class.' required.');
        }

        $client = HttpClientDiscovery::find();
        $this->assertInstanceOf(HttpClient::class, $client);
    }
}
