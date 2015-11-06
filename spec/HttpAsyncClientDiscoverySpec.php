<?php

namespace spec\Http\Discovery;

use PhpSpec\ObjectBehavior;

class HttpAsyncClientDiscoverySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\HttpAsyncClientDiscovery');
    }

    function it_is_a_class_discovery()
    {
        $this->shouldHaveType('Http\Discovery\ClassDiscovery');
    }

    function it_finds_an_http_client()
    {
        $this->find()->shouldImplement('Http\Client\HttpAsyncClient');
    }
}
