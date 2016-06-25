<?php

namespace Http\Discovery;

use Http\Client\HttpAsyncClient;
use Http\Discovery\Exception\DiscoveryFailedException;
use Http\Discovery\Exception\NotFoundException;

/**
 * Finds an HTTP Asynchronous Client.
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
final class HttpAsyncClientDiscovery extends ClassDiscovery
{
    /**
     * Finds an HTTP Async Client.
     *
     * @return HttpAsyncClient
     *
     * @throws NotFoundException
     */
    public static function find()
    {
        try {
            $asyncClient = static::findOneByType(HttpAsyncClient::class);

            return new $asyncClient();
        } catch (DiscoveryFailedException $e) {
            throw new NotFoundException(
                'No HTTPlug async clients found. Make sure to install a package providing "php-http/async-client-implementation". Example: "php-http/guzzle6-adapter".',
                0,
                $e
            );
        }
    }
}
