<?php

namespace spec\Http\Discovery\UriFactory;

use Psr\Http\Message\UriInterface;
use PhpSpec\ObjectBehavior;

class GuzzleFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\UriFactory\GuzzleFactory');
    }

    function it_is_a_uri_factory()
    {
        $this->shouldImplement('Http\Message\UriFactory');
    }

    function it_creates_a_uri_from_string()
    {
        $this->createUri('http://php-http.org')->shouldHaveType('Psr\Http\Message\UriInterface');
    }

    function it_creates_a_uri_from_uri(UriInterface $uri)
    {
        $this->createUri($uri)->shouldReturn($uri);
    }

    function it_throws_an_exception_when_uri_is_invalid()
    {
        $this->shouldThrow('InvalidArgumentException')->duringCreateUri(null);
    }
}
