<?php

namespace spec\Http\Discovery;

use PhpSpec\ObjectBehavior;

class HttpAdapterDiscoverySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\HttpAdapterDiscovery');
    }

    function it_is_a_class_discovery()
    {
        $this->shouldHaveType('Http\Discovery\ClassDiscovery');
    }

    function it_finds_an_http_adapter()
    {
        $this->find()->shouldHaveType('Http\Adapter\HttpAdapter');
    }
}
