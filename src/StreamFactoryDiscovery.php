<?php

namespace Http\Discovery;

use Http\Message\StreamFactory;

/**
 * Finds a Stream Factory.
 *
 * @author Михаил Красильников <m.krasilnikov@yandex.ru>
 */
final class StreamFactoryDiscovery extends ClassDiscovery
{
    /**
     * Finds a Stream Factory.
     *
     * @return StreamFactory
     */
    public static function find()
    {
        try {
            $streamFactory = static::findOneByType('Http\Message\StreamFactory');

            return new $streamFactory();
        } catch (NotFoundException $e) {
            throw new NotFoundException(
                'No factories found. To use Guzzle or Diactoros factories install php-http/message and the chosen message implementation.',
                0,
                $e
            );
        }
    }
}
