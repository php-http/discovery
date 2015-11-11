<?php

namespace spec\Http\Discovery\StreamFactory;

use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\ObjectBehavior;
use Zend\Diactoros\Stream;

class DiactorosStreamFactorySpec extends ObjectBehavior
{
    function let()
    {
        if (!class_exists('Zend\Diactoros\Stream')) {
            throw new SkippingException('Diactoros is not available');
        }
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\StreamFactory\DiactorosStreamFactory');
    }

    function it_is_a_stream_factory()
    {
        $this->shouldImplement('Http\Message\StreamFactory');
    }

    function it_creates_a_stream_from_string()
    {
        $this->createStream('foo')->shouldHaveType('Psr\Http\Message\StreamInterface');
    }

    function it_creates_a_stream_from_resource()
    {
        $this->createStream(fopen('php://memory', 'rw'))
            ->shouldHaveType('Psr\Http\Message\StreamInterface');
    }

    function it_creates_a_stream_from_stream()
    {
        $this->createStream(new Stream('php://memory'))
            ->shouldHaveType('Psr\Http\Message\StreamInterface');
    }

    function it_creates_a_stream_from_null()
    {
        $this->createStream(null)->shouldHaveType('Psr\Http\Message\StreamInterface');
    }
}
