<?php

namespace Http\Discovery\StreamFactory;

use Http\Message\StreamFactory;
use Psr\Http\Message\StreamInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;
use Zend\Diactoros\Stream;

/**
 * @author Михаил Красильников <m.krasilnikov@yandex.ru>
 */
class DiactorosStreamFactory implements StreamFactory
{
    /**
     * Creates a stream
     *
     * @param string|resource|StreamInterface|null $body
     *
     * @return StreamInterface
     *
     * @throws \InvalidArgumentException If the stream body is invalid
     * @throws \RuntimeException If cannot write into stream
     */
    public function createStream($body = null)
    {
        if (!$body instanceof StreamInterface) {
            if (is_resource($body)) {
                $body = new Stream($body);
            } else {
                $stream = new Stream('php://memory', 'rw');

                if (null !== $body) {
                    $stream->write((string) $body);
                }

                $body = $stream;
            }
        }

        $body->rewind();

        return $body;
    }
}
