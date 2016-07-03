<?php

namespace spec\Http\Discovery;

use Http\Client\HttpClient;
use Http\Discovery\ClassDiscovery;
use Http\Discovery\NotFoundException;
use Http\Discovery\Strategy\DiscoveryStrategy;
use Puli\GeneratedPuliFactory;
use Puli\Discovery\Api\Discovery;
use Puli\Discovery\Binding\ClassBinding;
use Puli\Repository\Api\ResourceRepository;
use PhpSpec\ObjectBehavior;
use spec\Http\Discovery\Helper\DiscoveryHelper;

class HttpClientDiscoverySpec extends ObjectBehavior
{
    function let()
    {
        ClassDiscovery::setStrategies([DiscoveryHelper::class]);
        DiscoveryHelper::clearClasses();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\HttpClientDiscovery');
    }

    function it_is_a_class_discovery()
    {
        $this->shouldHaveType('Http\Discovery\ClassDiscovery');
    }

    function it_finds_a_http_client(DiscoveryStrategy $strategy) {

        $candidate = ['class' => 'spec\Http\Discovery\Stub\HttpClientStub', 'condition' => true];
        DiscoveryHelper::setClasses(HttpClient::class, [$candidate]);

        $this->find()->shouldImplement('Http\Client\HttpClient');
    }

    function it_throw_exception(DiscoveryStrategy $strategy) {
        $this->shouldThrow(NotFoundException::class)->duringFind();
    }
}
