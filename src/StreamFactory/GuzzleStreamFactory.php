<?php

namespace Http\Discovery\StreamFactory;

use Http\Message\StreamFactory;
use Psr\Http\Message\StreamInterface;

/**
 * Creates Guzzle streams.
 *
 * @author Михаил Красильников <m.krasilnikov@yandex.ru>
 */
class GuzzleStreamFactory implements StreamFactory
{
    /**
     * {@inheritdoc}
     */
    public function createStream($body = null)
    {
        return \GuzzleHttp\Psr7\stream_for($body);
    }
}
