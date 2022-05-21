<?php

namespace spec\Http\Discovery;

use Http\Discovery\ClassDiscovery;
use Http\Discovery\NotFoundException;
use Http\Discovery\Strategy\DiscoveryStrategy;
use Http\Message\MessageFactory;
use PhpSpec\ObjectBehavior;
use spec\Http\Discovery\Helper\DiscoveryHelper;

class MessageFactoryDiscoverySpec extends ObjectBehavior
{
    function let()
    {
        ClassDiscovery::setStrategies([DiscoveryHelper::class]);
        DiscoveryHelper::clearClasses();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\MessageFactoryDiscovery');
    }

    function it_is_a_class_discovery()
    {
        $this->shouldHaveType('Http\Discovery\ClassDiscovery');
    }

    function it_finds_a_message_factory(DiscoveryStrategy $strategy) {

        $candidate = ['class' => 'spec\Http\Discovery\Stub\MessageFactoryStub', 'condition' => true];
        DiscoveryHelper::setClasses(MessageFactory::class, [$candidate]);

        $this->find()->shouldImplement('Http\Message\MessageFactory');
    }

    function it_throw_exception(DiscoveryStrategy $strategy) {
        $strategy->getCandidates('Http\Message\MessageFactory')->willReturn([]);

        $this->shouldThrow(NotFoundException::class)->duringFind();
    }
}
