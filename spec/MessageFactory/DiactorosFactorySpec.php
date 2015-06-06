<?php

namespace spec\Http\Discovery\MessageFactory;

use Psr\Http\Message\StreamInterface;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\ObjectBehavior;

class DiactorosFactorySpec extends ObjectBehavior
{
    function let()
    {
        if (!class_exists('Zend\Diactoros\Request')) {
            throw new SkippingException('Diactoros is not available');
        }
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\MessageFactory\DiactorosFactory');
    }

    function it_is_a_message_factory()
    {
        $this->shouldImplement('Http\Message\MessageFactory');
    }

    function it_creates_a_request()
    {
        $this->createRequest('GET', '/')->shouldHaveType('Psr\Http\Message\RequestInterface');
    }

    function it_creates_a_request_with_string_body()
    {
        $this->createRequest('POST', '/', '1.1', [], 'body')->shouldHaveType('Psr\Http\Message\RequestInterface');
    }

    function it_creates_a_request_with_empty_body()
    {
        $this->createRequest('POST', '/', '1.1', [], null)->shouldHaveType('Psr\Http\Message\RequestInterface');
    }

    function it_creates_a_request_with_stream_body(StreamInterface $stream)
    {
        $stream->rewind()->shouldBeCalled();

        $this->createRequest('POST', '/', '1.1', [], $stream)->shouldHaveType('Psr\Http\Message\RequestInterface');
    }

    function it_creates_a_request_with_resource_body()
    {
        $resource = tmpfile();

        $this->createRequest('POST', '/', '1.1', [], $resource)->shouldHaveType('Psr\Http\Message\RequestInterface');
    }

    function it_creates_a_response()
    {
        $this->createResponse()->shouldHaveType('Psr\Http\Message\ResponseInterface');
    }
}
