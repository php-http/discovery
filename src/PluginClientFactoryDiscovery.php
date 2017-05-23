<?php

namespace Http\Discovery;

use Http\Client\Common\PluginClientFactoryInterface;
use Http\Discovery\Exception\DiscoveryFailedException;

/**
 * Finds a PluginClientFactoryInterface implementation.
 *
 * @author Fabien Bourigault <bourigaultfabien@gmail.com>
 */
final class PluginClientFactoryDiscovery extends ClassDiscovery
{
    /**
     * Finds a PluginClientFactoryInterface implementation.
     *
     * @return PluginClientFactoryInterface
     *
     * @throws Exception\NotFoundException
     */
    public static function find()
    {
        try {
            $client = static::findOneByType(PluginClientFactoryInterface::class);
        } catch (DiscoveryFailedException $e) {
            throw new NotFoundException(
                'No HTTPlug plugin clients found. Make sure to install "php-http/client-common".',
                0,
                $e
            );
        }

        return static::instantiateClass($client);
    }
}
