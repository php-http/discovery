<?php

namespace spec\Http\Discovery;

use PhpSpec\ObjectBehavior;

class UriFactoryDiscoverySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\UriFactoryDiscovery');
    }

    function it_is_a_class_discovery()
    {
        $this->shouldHaveType('Http\Discovery\ClassDiscovery');
    }

    function it_finds_an_http_uri_factory()
    {
        $this->find()->shouldHaveType('Http\Message\UriFactory');
    }
}
