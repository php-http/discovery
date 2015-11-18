<?php

namespace Http\Discovery\StreamFactory;

use Http\Message\StreamFactory;
use Psr\Http\Message\StreamInterface;

/**
 * @author Михаил Красильников <m.krasilnikov@yandex.ru>
 */
class GuzzleStreamFactory implements StreamFactory
{
    /**
     * Creates a stream
     *
     * @param string|resource|StreamInterface|null $body
     *
     * @return StreamInterface
     *
     * @throws \InvalidArgumentException if the $body arg is not valid.
     */
    public function createStream($body = null)
    {
        return \GuzzleHttp\Psr7\stream_for($body);
    }
}
