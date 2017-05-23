<?php

namespace spec\Http\Discovery;

use Http\Client\Common\PluginClientFactoryInterface;
use Http\Discovery\ClassDiscovery;
use Http\Discovery\NotFoundException;
use Http\Discovery\Strategy\DiscoveryStrategy;
use PhpSpec\ObjectBehavior;
use spec\Http\Discovery\Helper\DiscoveryHelper;

class PluginClientFactoryDiscoverySpec extends ObjectBehavior
{
    function let()
    {
        ClassDiscovery::setStrategies([DiscoveryHelper::class]);
        DiscoveryHelper::clearClasses();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Discovery\PluginClientFactoryDiscovery');
    }

    function it_is_a_class_discovery()
    {
        $this->shouldHaveType('Http\Discovery\ClassDiscovery');
    }

    function it_finds_a_plugin_client_factory(DiscoveryStrategy $strategy) {

        $candidate = ['class' => 'spec\Http\Discovery\Stub\PluginClientFactoryStub', 'condition' => true];
        DiscoveryHelper::setClasses(PluginClientFactoryInterface::class, [$candidate]);

        $this->find()->shouldImplement('Http\Client\Common\PluginClientFactoryInterface');
    }

    function it_throw_exception(DiscoveryStrategy $strategy) {
        $this->shouldThrow(NotFoundException::class)->duringFind();
    }
}
