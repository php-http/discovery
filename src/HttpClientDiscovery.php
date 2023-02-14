<?php

namespace Http\Discovery;

use Http\Client\HttpClient;
use Http\Discovery\Exception\DiscoveryFailedException;

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
     * @param ?array{?connect_timeout: int, ?timeout: int} $options
     *
     * @return HttpClient
     *
     * @throws Exception\NotFoundException
     */
    public static function find(?array $options = null)
    {
        try {
            $client = static::findOneByType(HttpClient::class);
        } catch (DiscoveryFailedException $e) {
            throw new NotFoundException('No HTTPlug clients found. Make sure to install a package providing "php-http/client-implementation". Example: "php-http/guzzle6-adapter".', 0, $e);
        }

        return null !== $options
            ? static::instantiateClassWithOptions($client, $options);
            : static::instantiateClass($client);
    }
}
