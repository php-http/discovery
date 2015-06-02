<?php

namespace spec\Http\Discovery;

use PhpSpec\ObjectBehavior;

class HttpAdapterDiscoverySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\HttpAdapterDiscovery');
    }

    function it_registers_a_factory()
    {
        $this->reset();

        $this->register('guzzle6', 'spec\Http\Discovery\AnotherGuzzle6HttpAdapter');

        $this->find()->shouldHaveType('spec\Http\Discovery\AnotherGuzzle6HttpAdapter');
    }

    function it_resets_cache_when_a_factory_is_registered()
    {
        $this->reset();

        $firstMatch = $this->find();

        $this->register('guzzle6', 'spec\Http\Discovery\AnotherGuzzle6HttpAdapter');

        $this->find()->shouldNotBe($firstMatch);
    }

    function it_caches_a_found_adapter()
    {
        $this->reset();

        $firstMatch = $this->find()->shouldHaveType('spec\Http\Discovery\Guzzle6HttpAdapter');

        $this->find()->shouldReturn($firstMatch);
    }

    function it_finds_guzzle6_then_guzzle5_by_default()
    {
        $this->reset();

        $this->find()->shouldHaveType('spec\Http\Discovery\Guzzle6HttpAdapter');

        $this->register('guzzle6', 'invalid', '');

        $this->find()->shouldHaveType('spec\Http\Discovery\Guzzle5HttpAdapter');
    }

    function it_throws_an_exception_when_no_adapter_is_found()
    {
        $this->reset();

        $this->register('guzzle6', 'invalid', '');
        $this->register('guzzle5', 'invalid', '');

        $this->shouldThrow('Http\Discovery\NotFoundException')->duringFind();
    }

    function reset()
    {
        $this->register('guzzle5', 'spec\Http\Discovery\Guzzle5HttpAdapter');
        $this->register('guzzle6', 'spec\Http\Discovery\Guzzle6HttpAdapter');
    }
}

class Guzzle5HttpAdapter {}
class Guzzle6HttpAdapter {}
class AnotherGuzzle6HttpAdapter {}
