<?php

namespace Http\Discovery\StreamFactory;

use Http\Message\StreamFactory;
use Psr\Http\Message\StreamInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;
use Zend\Diactoros\Stream;

/**
 * Creates Diactoros streams.
 *
 * @author Михаил Красильников <m.krasilnikov@yandex.ru>
 */
final class DiactorosStreamFactory implements StreamFactory
{
    /**
     * {@inheritdoc}
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
