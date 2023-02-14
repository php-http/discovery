<?php

namespace Http\Discovery;

use Http\Discovery\Exception\DiscoveryFailedException;
use Psr\Http\Client\ClientInterface;

/**
 * Finds a PSR-18 HTTP Client.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Psr18ClientDiscovery extends ClassDiscovery
{
    /**
     * Finds a PSR-18 HTTP Client.
     *
     * @param ?array{?connect_timeout: int, ?timeout: int} $options
     *
     * @return ClientInterface
     *
     * @throws Exception\NotFoundException
     */
    public static function find(?array $options = null)
    {
        try {
            $client = static::findOneByType(ClientInterface::class);
        } catch (DiscoveryFailedException $e) {
            throw new \Http\Discovery\Exception\NotFoundException('No PSR-18 clients found. Make sure to install a package providing "psr/http-client-implementation". Example: "php-http/guzzle7-adapter".', 0, $e);
        }

        return null !== $options
            ? static::instantiateClassWithOptions($client, $options);
            : static::instantiateClass($client);
    }
}
