<?php

namespace spec\Http\Discovery\Stub;

use Http\Client\Common\PluginClientFactoryInterface;

class PluginClientFactoryStub implements PluginClientFactoryInterface
{
    public function createClient($client, array $plugins = [], array $options = [])
    {

    }
}
