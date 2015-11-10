<?php

namespace spec\Http\Discovery\StreamFactory;

use GuzzleHttp\Psr7\Stream;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\ObjectBehavior;

class GuzzleStreamFactorySpec extends ObjectBehavior
{
    public function let()
    {
        if (!class_exists('GuzzleHttp\Psr7\Stream')) {
            throw new SkippingException('GuzzleHttp is not available');
        }
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\StreamFactory\GuzzleStreamFactory');
    }

    public function it_is_a_stream_factory()
    {
        $this->shouldImplement('Http\Message\StreamFactory');
    }

    public function it_creates_a_stream_from_string()
    {
        $this->createStream('foo')->shouldHaveType('Psr\Http\Message\StreamInterface');
    }

    public function it_creates_a_stream_from_resource()
    {
        $this->createStream(fopen('php://memory', 'rw'))
            ->shouldHaveType('Psr\Http\Message\StreamInterface');
    }

    public function it_creates_a_stream_from_stream()
    {
        $this->createStream(new Stream(fopen('php://memory', 'rw')))
            ->shouldHaveType('Psr\Http\Message\StreamInterface');
    }

    public function it_creates_a_stream_from_null()
    {
        $this->createStream(null)->shouldHaveType('Psr\Http\Message\StreamInterface');
    }
}
