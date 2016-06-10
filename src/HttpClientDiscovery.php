<?php

namespace Http\Discovery;

use Http\Client\HttpClient;
use Http\Discovery\Exception\DiscoveryFailedException;
use Http\Discovery\Exception\NotFoundException;

/**
 * Finds an HTTP Client.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class HttpClientDiscovery extends ClassDiscovery
{
    /**
     * Finds an HTTP Client.
     *
     * @return HttpClient
     *
     * @throws NotFoundException
     */
    public static function find()
    {
        try {
            $client = static::findOneByType(HttpClient::class);

            return new $client();
        } catch (DiscoveryFailedException $e) {
            throw new NotFoundException(
                'No HTTPlug clients found. Make sure to install a package providing "php-http/client-implementation". Example: "php-http/guzzle6-adapter".',
                0,
                $e
            );
        }
    }
}
