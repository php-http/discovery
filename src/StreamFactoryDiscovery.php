<?php

namespace Http\Discovery;

use Http\Discovery\Exception\DiscoveryFailedException;
use Http\Discovery\Exception\NotFoundException;
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
     *
     * @throws NotFoundException
     */
    public static function find()
    {
        try {
            $streamFactory = static::findOneByType(StreamFactory::class);

            return new $streamFactory();
        } catch (DiscoveryFailedException $e) {
            throw new NotFoundException(
                'No stream factories found. To use Guzzle or Diactoros factories install php-http/message and the chosen message implementation.',
                0,
                $e
            );
        }
    }
}
