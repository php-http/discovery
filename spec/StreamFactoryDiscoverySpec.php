<?php

namespace spec\Http\Discovery;

use Puli\GeneratedPuliFactory;
use Puli\Discovery\Api\Discovery;
use Puli\Discovery\Binding\ClassBinding;
use Puli\Repository\Api\ResourceRepository;
use PhpSpec\ObjectBehavior;

class StreamFactoryDiscoverySpec extends ObjectBehavior
{
    function let(
        GeneratedPuliFactory $puliFactory,
        ResourceRepository $repository,
        Discovery $discovery
    ) {
        $puliFactory->createRepository()->willReturn($repository);
        $puliFactory->createDiscovery($repository)->willReturn($discovery);

        $this->setPuliFactory($puliFactory);
    }

    function letgo()
    {
        $this->resetPuliFactory();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\StreamFactoryDiscovery');
    }

    function it_is_a_class_discovery()
    {
        $this->shouldHaveType('Http\Discovery\ClassDiscovery');
    }

    function it_finds_a_stream_factory(
        Discovery $discovery,
        ClassBinding $binding
    ) {
        $binding->hasParameterValue('depends')->willReturn(false);
        $binding->getClassName()->willReturn('spec\Http\Discovery\Stub\StreamFactoryStub');

        $discovery->findBindings('Http\Message\StreamFactory')->willReturn([$binding]);

        $this->find()->shouldImplement('Http\Message\StreamFactory');
    }
}
