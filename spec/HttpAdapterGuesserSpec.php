<?php

namespace spec\Http\Guesser;

use PhpSpec\ObjectBehavior;

class HttpAdapterGuesserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Guesser\HttpAdapterGuesser');
    }

    function it_registers_a_factory()
    {
        $this->reset();

        $this->register('guzzle6', 'spec\Http\Guesser\AnotherGuzzle6HttpAdapter');

        $this->guess()->shouldHaveType('spec\Http\Guesser\AnotherGuzzle6HttpAdapter');
    }

    function it_resets_cache_when_a_factory_is_registered()
    {
        $this->reset();

        $firstGuess = $this->guess();

        $this->register('guzzle6', 'spec\Http\Guesser\AnotherGuzzle6HttpAdapter');

        $this->guess()->shouldNotBe($firstGuess);
    }

    function it_caches_guess()
    {
        $this->reset();

        $firstGuess = $this->guess()->shouldHaveType('spec\Http\Guesser\Guzzle6HttpAdapter');

        $this->guess()->shouldReturn($firstGuess);
    }

    function it_guesses_guzzle6_then_guzzle5_by_default()
    {
        $this->reset();

        $this->guess()->shouldHaveType('spec\Http\Guesser\Guzzle6HttpAdapter');

        $this->register('guzzle6', 'invalid', '');

        $this->guess()->shouldHaveType('spec\Http\Guesser\Guzzle5HttpAdapter');
    }

    function it_throws_an_exception_when_no_message_factory_is_found()
    {
        $this->reset();

        $this->register('guzzle6', 'invalid', '');
        $this->register('guzzle5', 'invalid', '');

        $this->shouldThrow('Http\Guesser\CannotGuessException')->duringGuess();
    }

    function reset()
    {
        $this->register('guzzle5', 'spec\Http\Guesser\Guzzle5HttpAdapter');
        $this->register('guzzle6', 'spec\Http\Guesser\Guzzle6HttpAdapter');
    }
}

class Guzzle5HttpAdapter {}
class Guzzle6HttpAdapter {}
class AnotherGuzzle6HttpAdapter {}
