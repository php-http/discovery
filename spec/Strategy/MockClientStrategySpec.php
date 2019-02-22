<?php

namespace spec\Http\Discovery\Strategy;

use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Http\Discovery\ClassDiscovery;
use Http\Discovery\Strategy\DiscoveryStrategy;
use Http\Discovery\Strategy;
use PhpSpec\ObjectBehavior;
use spec\Http\Discovery\Helper\DiscoveryHelper;

class MockClientStrategySpec extends ObjectBehavior
{
    function let()
    {
        ClassDiscovery::setStrategies([Strategy\MockClientStrategy::class]);
    }

    function it_should_return_the_mock_client(DiscoveryStrategy $strategy)
    {
        $candidates = $this->getCandidates(HttpClient::class);
        $candidates->shouldBeArray();
        $candidates->shouldHaveCount(1);
    }

    function it_should_return_the_mock_client_as_async(DiscoveryStrategy $strategy)
    {
        $candidates = $this->getCandidates(HttpAsyncClient::class);
        $candidates->shouldBeArray();
        $candidates->shouldHaveCount(1);
    }
}
