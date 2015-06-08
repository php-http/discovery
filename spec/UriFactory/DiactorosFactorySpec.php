<?php

namespace spec\Http\Discovery\UriFactory;

use Psr\Http\Message\UriInterface;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\ObjectBehavior;

class DiactorosFactorySpec extends ObjectBehavior
{
    function let()
    {
        if (!class_exists('Zend\Diactoros\Uri')) {
            throw new SkippingException('Diactoros is not available');
        }
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\UriFactory\DiactorosFactory');
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
