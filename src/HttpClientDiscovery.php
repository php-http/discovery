<?php

namespace Http\Discovery;

use Http\Client\HttpClient;
use Http\Discovery\Exception\DiscoveryFailedException;
use Psr\Http\Client\ClientInterface;

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
     * @throws Exception\NotFoundException
     */
    public static function find()
    {
        try {
            $client = static::findOneByType(HttpClient::class);
        } catch (DiscoveryFailedException $e) {
            throw new NotFoundException(
                'No HTTPlug clients found. Make sure to install a package providing "php-http/client-implementation". Example: "php-http/guzzle6-adapter".',
                0,
                $e
            );
        }

        return static::instantiateClass($client);
    }

    /**
     * Finds a PSR-18 HTTP Client.
     *
     * @return ClientInterface
     *
     * @throws Exception\NotFoundException
     */
    public static function findPsr18Client()
    {
        try {
            $client = static::findOneByType(ClientInterface::class);
        } catch (DiscoveryFailedException $e) {
            throw new \Http\Discovery\Exception\NotFoundException(
                'No PSR-18 clients found. Make sure to install a package providing "psr/http-client-implementation". Example: "php-http/guzzle6-adapter".',
                0,
                $e
            );
        }

        return static::instantiateClass($client);
    }
}
