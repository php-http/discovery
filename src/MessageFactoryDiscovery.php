<?php

namespace Http\Discovery;

use Http\Message\MessageFactory;

/**
 * Finds a Message Factory.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class MessageFactoryDiscovery extends ClassDiscovery
{
    /**
     * Finds a Message Factory.
     *
     * @return MessageFactory
     */
    public static function find()
    {
        try {
            $messageFactory = static::findOneByType('Http\Message\MessageFactory');

            return new $messageFactory();
        } catch (NotFoundException $e) {
            throw new NotFoundException(
                'No factories found. To use Guzzle or Diactoros factories install php-http/message and the chosen message implementation.',
                0,
                $e
            );
        }
    }
}
