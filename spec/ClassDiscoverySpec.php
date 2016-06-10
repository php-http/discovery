<?php

namespace spec\Http\Discovery;

use Http\Discovery\ClassDiscovery;
use Puli\Discovery\Binding\ClassBinding;
use Puli\GeneratedPuliFactory;
use Puli\Discovery\Api\Discovery;
use Puli\Repository\Api\ResourceRepository;
use PhpSpec\ObjectBehavior;

class ClassDiscoverySpec extends ObjectBehavior
{
    function let(
        GeneratedPuliFactory $puliFactory,
        ResourceRepository $repository,
        Discovery $discovery
    ) {
        $puliFactory->createRepository()->willReturn($repository);
        $puliFactory->createDiscovery($repository)->willReturn($discovery);

        $this->beAnInstanceOf('spec\Http\Discovery\ClassDiscoveryStub');
        $this->setPuliFactory($puliFactory);
    }

    function letgo()
    {
        $this->resetPuliFactory();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\ClassDiscovery');
    }

    function it_has_a_puli_factory(GeneratedPuliFactory $puliFactory)
    {
        $this->getPuliFactory()->shouldReturn($puliFactory);
    }

    function it_has_a_puli_discovery(Discovery $discovery)
    {
        $this->getPuliDiscovery()->shouldReturn($discovery);
    }

    function it_throws_an_exception_when_binding_not_found(Discovery $discovery)
    {
        $discovery->findBindings('InvalidBinding')->willReturn([]);

        $this->shouldThrow('Http\Discovery\Exception\NotFoundException')->duringFindOneByType('InvalidBinding');
    }

    function it_returns_a_class_binding(Discovery $discovery, ClassBinding $binding)
    {
        $binding->hasParameterValue('depends')->willReturn(false);
        $binding->getClassName()->willReturn('ClassName');

        $discovery->findBindings('Binding')->willReturn([$binding]);

        $this->findOneByType('Binding')->shouldReturn('ClassName');
    }

    function it_returns_a_class_binding_with_dependency(
        Discovery $discovery,
        ClassBinding $binding1,
        ClassBinding $binding2
    ) {
        $binding1->hasParameterValue('depends')->willReturn(true);
        $binding1->getParameterValue('depends')->willReturn(false);

        $binding2->hasParameterValue('depends')->willReturn(false);
        $binding2->getClassName()->willReturn('ClassName');

        $discovery->findBindings('Binding')->willReturn([
            $binding1,
            $binding2,
        ]);

        $this->findOneByType('Binding')->shouldReturn('ClassName');
    }
}

class ClassDiscoveryStub extends ClassDiscovery
{
}
