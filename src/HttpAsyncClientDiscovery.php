<?php

namespace Http\Discovery;

use Http\Client\HttpAsyncClient;

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
     */
    public static function find()
    {
        $asyncClient = static::findOneByType('Http\Client\HttpAsyncClient');

        return new $asyncClient();
    }
}
