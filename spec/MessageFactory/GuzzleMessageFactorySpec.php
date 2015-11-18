<?php

namespace spec\Http\Discovery\MessageFactory;

use Psr\Http\Message\StreamInterface;
use PhpSpec\ObjectBehavior;

class GuzzleMessageFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\MessageFactory\GuzzleMessageFactory');
    }

    function it_is_a_message_factory()
    {
        $this->shouldImplement('Http\Message\MessageFactory');
    }

    function it_creates_a_request()
    {
        $this->createRequest('GET', '/')->shouldHaveType('Psr\Http\Message\RequestInterface');
    }

    function it_creates_a_response()
    {
        $this->createResponse()->shouldHaveType('Psr\Http\Message\ResponseInterface');
    }
}
