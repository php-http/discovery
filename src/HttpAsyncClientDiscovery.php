<?php

namespace Http\Discovery;

use Http\Client\HttpAsyncClient;

/**
 * Finds an HTTP Asynchronous Client
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
final class HttpAsyncClientDiscovery extends ClassDiscovery
{
    /**
     * @var HttpAsyncClient
     */
    protected static $cache;

    /**
     * @var array
     */
    protected static $classes = [
        'guzzle6' => [
            'class'     => 'Http\Adapter\Guzzle6HttpAdapter',
            'condition' => 'Http\Adapter\Guzzle6HttpAdapter',
        ],
    ];

    /**
     * Finds an HTTP Async Client
     *
     * @return HttpAsyncClient
     *
     * @throws NotFoundException
     */
    public static function find()
    {
        // Override only used for return type declaration
        return parent::find();
    }
}
