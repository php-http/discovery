<?php

namespace Http\Discovery;

/**
 * Finds a Factory.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class FactoryDiscovery extends ClassDiscovery
{
    /**
     * {@inheritdoc}
     */
    public static function find()
    {
        try {
            return parent::find();
        } catch (NotFoundException $e) {
            throw new NotFoundException(
                'No factories found. Install php-http/utils >= 0.2 to use Guzzle or Diactoros factories.',
                0,
                $e
            );
        }
    }
}
