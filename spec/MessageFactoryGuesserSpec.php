<?php

namespace spec\Http\Guesser;

use PhpSpec\ObjectBehavior;

class MessageFactoryGuesserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Guesser\MessageFactoryGuesser');
    }

    function it_registers_a_factory()
    {
        $this->reset();

        $this->register('guzzle', 'spec\Http\Guesser\TestClass', 'spec\Http\Guesser\Factory');

        $this->guess()->shouldHaveType('spec\Http\Guesser\Factory');
    }

    function it_resets_cache_when_a_factory_is_registered()
    {
        $this->reset();

        $firstGuess = $this->guess();

        $this->register('guzzle', 'spec\Http\Guesser\TestClass', 'spec\Http\Guesser\Factory');

        $this->guess()->shouldNotBe($firstGuess);
    }

    function it_caches_guess()
    {
        $this->reset();

        $firstGuess = $this->guess()->shouldHaveType('Http\Guesser\MessageFactory\GuzzleFactory');

        $this->guess()->shouldReturn($firstGuess);
    }

    function it_guesses_guzzle_then_zend_by_default()
    {
        $this->reset();

        $this->guess()->shouldHaveType('Http\Guesser\MessageFactory\GuzzleFactory');

        $this->register('guzzle', 'invalid', '');

        if (class_exists('Zend\Diactoros\Request')) {
            $this->guess()->shouldHaveType('Http\Guesser\MessageFactory\DiactorosFactory');
        }
    }

    function it_throws_an_exception_when_no_message_factory_is_found()
    {
        $this->reset();

        $this->register('guzzle', 'invalid', '');
        $this->register('diactoros', 'invalid', '');

        $this->shouldThrow('Http\Guesser\CannotGuessException')->duringGuess();
    }

    function reset()
    {
        $this->register('guzzle', 'GuzzleHttp\Psr7\Request', 'Http\Guesser\MessageFactory\GuzzleFactory');
        $this->register('diactoros', 'Zend\Diactoros\Request', 'Http\Guesser\MessageFactory\DiactorosFactory');
    }
}

class TestClass {}
class Factory {}
