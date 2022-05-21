<?php

namespace spec\Http\Discovery\Strategy;

use Http\Discovery\Strategy\PuliBetaStrategy;
use Puli\Discovery\Binding\ClassBinding;
use Puli\GeneratedPuliFactory;
use Puli\Discovery\Api\Discovery;
use Puli\Repository\Api\ResourceRepository;
use PhpSpec\ObjectBehavior;

/**
 * @require \PuliIsSupported
 */
class PuliSpec extends ObjectBehavior
{
    function let(
        GeneratedPuliFactory $puliFactory,
        ResourceRepository $repository,
        Discovery $discovery
    ) {
        $puliFactory->createRepository()->willReturn($repository);
        $puliFactory->createDiscovery($repository)->willReturn($discovery);
        $this->beAnInstanceOf('spec\Http\Discovery\Strategy\PuliBetaStrategyStub');
        $this->setPuliFactory($puliFactory);
    }

    function letgo()
    {
        $this->resetPuliFactory();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\Strategy\PuliBetaStrategy');
    }

    function it_returns_a_class_binding(Discovery $discovery, ClassBinding $binding)
    {
        $binding->hasParameterValue('depends')->willReturn(false);
        $binding->getClassName()->willReturn('ClassName');

        $discovery->findBindings('Binding')->willReturn([$binding]);

        $this->getCandidates('Binding')->shouldHaveCandidate('ClassName', true);
    }

    function it_returns_a_class_binding_with_dependency(
        Discovery $discovery,
        ClassBinding $binding1,
        ClassBinding $binding2
    ) {
        $binding1->hasParameterValue('depends')->willReturn(true);
        $binding1->getParameterValue('depends')->willReturn('foobar');
        $binding1->getClassName()->willReturn('ClassName1');


        $binding2->hasParameterValue('depends')->willReturn(false);
        $binding2->getClassName()->willReturn('ClassName2');

        $discovery->findBindings('Binding')->willReturn([
            $binding1,
            $binding2,
        ]);

        $this->getCandidates('Binding')->shouldHaveCandidate('ClassName1', 'foobar');
        $this->getCandidates('Binding')->shouldHaveCandidate('ClassName2', true);
    }


    public function getMatchers(): array
    {
        return [
            'haveCandidate' => function ($subject, $class, $condition) {
                foreach ($subject as $candidate) {
                    if ($candidate['class'] === $class && $candidate['condition'] === $condition) {
                        return true;
                    }
                }
                return false;
            }
        ];
    }
}

class PuliBetaStrategyStub extends PuliBetaStrategy
{
    /**
     * Sets the Puli factory.
     *
     * @param object $puliFactory
     */
    public static function setPuliFactory($puliFactory)
    {
        if (!is_callable([$puliFactory, 'createRepository']) || !is_callable([$puliFactory, 'createDiscovery'])) {
            throw new \InvalidArgumentException('The Puli Factory must expose a repository and a discovery');
        }
        self::$puliFactory = $puliFactory;
        self::$puliDiscovery = null;
    }
    /**
     * Resets the factory.
     */
    public static function resetPuliFactory()
    {
        self::$puliFactory = null;
        self::$puliDiscovery = null;
    }
}
