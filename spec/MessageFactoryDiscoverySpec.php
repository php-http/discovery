<?php

namespace spec\Http\Discovery;

use PhpSpec\ObjectBehavior;

class MessageFactoryDiscoverySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\MessageFactoryDiscovery');
    }

    function it_registers_a_factory()
    {
        $this->reset();

        $this->register('guzzle', 'spec\Http\Discovery\TestClass', 'spec\Http\Discovery\Factory');

        $this->find()->shouldHaveType('spec\Http\Discovery\Factory');
    }

    function it_resets_cache_when_a_factory_is_registered()
    {
        $this->reset();

        $firstGuess = $this->find();

        $this->register('guzzle', 'spec\Http\Discovery\TestClass', 'spec\Http\Discovery\Factory');

        $this->find()->shouldNotBe($firstGuess);
    }

    function it_caches_a_found_message_factory()
    {
        $this->reset();

        $firstGuess = $this->find()->shouldHaveType('Http\Discovery\MessageFactory\GuzzleFactory');

        $this->find()->shouldReturn($firstGuess);
    }

    function it_finds_guzzle_then_zend_by_default()
    {
        $this->reset();

        $this->find()->shouldHaveType('Http\Discovery\MessageFactory\GuzzleFactory');

        $this->register('guzzle', 'invalid', '');

        if (class_exists('Zend\Diactoros\Request')) {
            $this->find()->shouldHaveType('Http\Discovery\MessageFactory\DiactorosFactory');
        }
    }

    function it_throws_an_exception_when_no_message_factory_is_found()
    {
        $this->reset();

        $this->register('guzzle', 'invalid', '');
        $this->register('diactoros', 'invalid', '');

        $this->shouldThrow('Http\Discovery\NotFoundException')->duringFind();
    }

    function reset()
    {
        $this->register('guzzle', 'GuzzleHttp\Psr7\Request', 'Http\Discovery\MessageFactory\GuzzleFactory');
        $this->register('diactoros', 'Zend\Diactoros\Request', 'Http\Discovery\MessageFactory\DiactorosFactory');
    }
}

class TestClass {}
class Factory {}
