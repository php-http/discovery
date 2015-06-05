<?php

namespace spec\Http\Discovery;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UriFactoryDiscoverySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\UriFactoryDiscovery');
    }

    function it_finds_guzzle_then_zend_by_default()
    {
        $this->find()->shouldHaveType('Http\Discovery\UriFactory\GuzzleFactory');

        $this->register('guzzle', 'invalid', '');

        if (class_exists('Zend\Diactoros\Request')) {
            $this->find()->shouldHaveType('Http\Discovery\UriFactory\DiactorosFactory');
        }
    }
}
