<?php

namespace spec\Http\Discovery\Stub;

use Http\Message\StreamFactory;

class StreamFactoryStub implements StreamFactory
{
    public function createStream($body = null)
    {
    }
}
