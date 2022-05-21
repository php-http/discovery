<?php

namespace spec\Http\Discovery;

use Http\Discovery\ClassDiscovery;
use Http\Discovery\NotFoundException;
use Http\Discovery\Strategy\DiscoveryStrategy;
use Http\Message\StreamFactory;
use PhpSpec\ObjectBehavior;
use spec\Http\Discovery\Helper\DiscoveryHelper;

class StreamFactoryDiscoverySpec extends ObjectBehavior
{
    function let()
    {
        ClassDiscovery::setStrategies([DiscoveryHelper::class]);
        DiscoveryHelper::clearClasses();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\StreamFactoryDiscovery');
    }

    function it_is_a_class_discovery()
    {
        $this->shouldHaveType('Http\Discovery\ClassDiscovery');
    }

    function it_finds_a_stream_factory(DiscoveryStrategy $strategy) {

        $candidate = ['class' => 'spec\Http\Discovery\Stub\StreamFactoryStub', 'condition' => true];
        DiscoveryHelper::setClasses(StreamFactory::class, [$candidate]);

        $this->find()->shouldImplement('Http\Message\StreamFactory');
    }

    function it_throw_exception(DiscoveryStrategy $strategy) {
        $strategy->getCandidates('Http\Message\StreamFactory')->willReturn([]);

        $this->shouldThrow(NotFoundException::class)->duringFind();
    }
}
