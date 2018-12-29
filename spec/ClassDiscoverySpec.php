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
use spec\Http\Discovery\Helper\FailedDiscoveryStrategy;
use spec\Http\Discovery\Helper\SuccessfullDiscoveryStrategy;

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

    function it_returns_a_class()
    {
        $candidate = ['class' => 'ClassName', 'condition' => true];
        DiscoveryHelper::setClasses('Foobar', [$candidate]);

        $this->find('Foobar')->shouldReturn('ClassName');
    }

    function it_validates_conditions() {
        $c0 = ['class' => 'ClassName0', 'condition' => false];
        $c0b = ['class' => 'ClassName0', 'condition' => [false, true]];
        $c0c = ['class' => 'ClassName0', 'condition' => [true, false]];
        $c0d = ['class' => 'ClassName0', 'condition' => [true, false, true]];
        $c0e = ['class' => 'ClassName0', 'condition' => [false, function() {
            throw new \RuntimeException('This should never be called');
        }]];
        $c1 = ['class' => 'ClassName1', 'condition' => true];
        $c2 = ['class' => 'ClassName2', 'condition' => false];
        $c3 = ['class' => 'ClassName3', 'condition' => true];
        DiscoveryHelper::setClasses('Foobar', [$c0, $c0b, $c0c, $c0d, $c0e, $c1, $c2, $c3]);

        $this->find('Foobar')->shouldReturn('ClassName1');
    }

    function it_prepends_strategies() {
        $candidate = ['class' => 'Added'];
        DiscoveryHelper::setClasses('Foobar', [$candidate]);

        ClassDiscovery::setStrategies([SuccessfullDiscoveryStrategy::class]);
        ClassDiscovery::prependStrategy(DiscoveryHelper::class);

        $this->find('Foobar')->shouldReturn('Added');
    }

    function it_appends_strategies() {
        $candidate = ['class' => 'Added'];
        DiscoveryHelper::setClasses('Foobar', [$candidate]);

        // Make sure our strategy is added to the list
        ClassDiscovery::setStrategies([FailedDiscoveryStrategy::class]);
        ClassDiscovery::appendStrategy(DiscoveryHelper::class);

        $this->find('Foobar')->shouldReturn('Added');

        // Make sure it is added last in the list
        ClassDiscovery::setStrategies([SuccessfullDiscoveryStrategy::class]);
        ClassDiscovery::appendStrategy(DiscoveryHelper::class);

        $this->find('Foobar')->shouldReturn('Success');
    }
}



class ClassDiscoveryStub extends ClassDiscovery
{
    public static function find($type)
    {
        return self::findOneByType($type);
    }
}
