<?php

namespace spec\Http\Discovery;

use Http\Discovery\ClassDiscovery;
use Http\Discovery\NotFoundException;
use Http\Discovery\Strategy\DiscoveryStrategy;
use Http\Message\UriFactory;
use PhpSpec\ObjectBehavior;
use spec\Http\Discovery\Helper\DiscoveryHelper;

class UriFactoryDiscoverySpec extends ObjectBehavior
{
    function let()
    {
        ClassDiscovery::setStrategies([DiscoveryHelper::class]);
        DiscoveryHelper::clearClasses();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\UriFactoryDiscovery');
    }

    function it_is_a_class_discovery()
    {
        $this->shouldHaveType('Http\Discovery\ClassDiscovery');
    }

    function it_finds_a_uri_factory(DiscoveryStrategy $strategy) {

        $candidate = ['class' => 'spec\Http\Discovery\Stub\UriFactoryStub', 'condition' => true];
        DiscoveryHelper::setClasses(UriFactory::class, [$candidate]);

        $this->find()->shouldImplement('Http\Message\UriFactory');
    }

    function it_throw_exception(DiscoveryStrategy $strategy) {
        $strategy->getCandidates('Http\Message\UriFactory')->willReturn([]);

        $this->shouldThrow(NotFoundException::class)->duringFind();
    }
}
