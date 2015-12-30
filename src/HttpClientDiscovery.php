<?php

namespace Http\Discovery;

use Http\Client\HttpClient;

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
     */
    public static function find()
    {
        $client = static::findOneByType('Http\Client\HttpClient');

        return new $client();
    }
}
