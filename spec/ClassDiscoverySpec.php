<?php

namespace spec\Http\Discovery;

use Http\Discovery\ClassDiscovery;
use Http\Discovery\Exception\DiscoveryFailedException;
use Http\Discovery\Strategy\DiscoveryStrategy;
use Puli\Discovery\Binding\ClassBinding;
use Puli\GeneratedPuliFactory;
use Puli\Discovery\Api\Discovery;
use Puli\Repository\Api\ResourceRepository;
use PhpSpec\ObjectBehavior;
use spec\Http\Discovery\Helper\DiscoveryHelper;

class ClassDiscoverySpec extends ObjectBehavior
{
    function let() {
        ClassDiscovery::setStrategies([DiscoveryHelper::class]);
        DiscoveryHelper::clearClasses();
        $this->beAnInstanceOf('spec\Http\Discovery\ClassDiscoveryStub');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\ClassDiscovery');
    }

    function it_throws_an_exception_when_no_candidate_found(DiscoveryStrategy $strategy)
    {
        $strategy->getCandidates('NoCandidate')->willReturn([]);

        $this->shouldThrow(DiscoveryFailedException::class)->duringFind('NoCandidate');
    }

    function it_returns_a_class(DiscoveryStrategy $strategy)
    {
        $candidate = ['class' => 'ClassName', 'condition' => true];
        DiscoveryHelper::setClasses('Foobar', [$candidate]);

        $this->find('Foobar')->shouldReturn('ClassName');
    }

    function it_validates_conditions(DiscoveryStrategy $strategy) {
        $c0 = ['class' => 'ClassName0', 'condition' => false];
        $c1 = ['class' => 'ClassName1', 'condition' => true];
        $c2 = ['class' => 'ClassName2', 'condition' => false];
        DiscoveryHelper::setClasses('Foobar', [$c0, $c1, $c2]);

        $this->find('Foobar')->shouldReturn('ClassName1');
    }
}

class ClassDiscoveryStub extends ClassDiscovery
{
    public static function find($type)
    {
        return self::findOneByType($type);
    }
}
