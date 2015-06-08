<?php

namespace spec\Http\Discovery;

use Http\Discovery\ClassDiscovery;
use PhpSpec\ObjectBehavior;

class ClassDiscoverySpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\Http\Discovery\DiscoveryStub');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\ClassDiscovery');
    }

    function it_registers_a_class()
    {
        $this->reset();

        $this->register('class1', 'spec\Http\Discovery\AnotherClassToFind');

        $this->find()->shouldHaveType('spec\Http\Discovery\AnotherClassToFind');
    }

    function it_registers_a_class_with_a_condition()
    {
        $this->reset();

        $this->register('class1', 'spec\Http\Discovery\ClassToFind', false);
        $this->register('class2', 'spec\Http\Discovery\AnotherClassToFind', 'spec\Http\Discovery\TestClass');

        $this->find()->shouldHaveType('spec\Http\Discovery\AnotherClassToFind');
    }

    function it_registers_a_class_with_a_callable_condition()
    {
        $this->reset();

        $this->register('class1', 'spec\Http\Discovery\ClassToFind', false);
        $this->register('class2', 'spec\Http\Discovery\AnotherClassToFind', function() { return true; });

        $this->find()->shouldHaveType('spec\Http\Discovery\AnotherClassToFind');
    }

    function it_registers_a_class_with_a_boolean_condition()
    {
        $this->reset();

        $this->register('class1', 'spec\Http\Discovery\ClassToFind', false);
        $this->register('class2', 'spec\Http\Discovery\AnotherClassToFind', true);

        $this->find()->shouldHaveType('spec\Http\Discovery\AnotherClassToFind');
    }

    function it_registers_a_class_with_an_invalid_condition()
    {
        $this->reset();

        $this->register('class1', 'spec\Http\Discovery\ClassToFind', new \stdClass);
        $this->register('class2', 'spec\Http\Discovery\AnotherClassToFind', true);

        $this->find()->shouldHaveType('spec\Http\Discovery\AnotherClassToFind');
    }

    function it_resets_cache_when_a_class_is_registered()
    {
        $this->reset();

        $this->find()->shouldHaveType('spec\Http\Discovery\ClassToFind');

        $this->register('class1', 'spec\Http\Discovery\AnotherClassToFind');

        $this->find()->shouldHaveType('spec\Http\Discovery\AnotherClassToFind');
    }

    function it_caches_a_found_class()
    {
        $this->reset();

        $this->find()->shouldHaveType('spec\Http\Discovery\ClassToFind');

        $this->registerWithoutCacheReset('class1', 'spec\Http\Discovery\AnotherClassToFind');

        $this->find()->shouldhaveType('spec\Http\Discovery\ClassToFind');
    }

    function it_throws_an_exception_when_no_class_is_found()
    {
        $this->reset();

        $this->register('class1', 'invalid');

        $this->shouldThrow('Http\Discovery\NotFoundException')->duringFind();
    }
}

class DiscoveryStub extends ClassDiscovery
{
    protected static $cache;

    /**
     * @var array
     */
    protected static $classes;

    /**
     * Reset classes
     */
    public function reset()
    {
        static::$cache = null;

        static::$classes = [
            'class1' => [
                'class'     => 'spec\Http\Discovery\ClassToFind',
                'condition' => 'spec\Http\Discovery\ClassToFind'
            ],
        ];
    }

    public function registerWithoutCacheReset($name, $class, $condition = null)
    {
        static::$classes[$name] = [
            'class'     => $class,
            'condition' => $condition ?: $class,
        ];
    }
}

class ClassToFind {}
class AnotherClassToFind {}
class TestClass {}
