<?php

namespace Http\Discovery;

use Http\Message\StreamFactory;

/**
 * Finds a Stream Factory.
 *
 * @author Михаил Красильников <m.krasilnikov@yandex.ru>
 */
final class StreamFactoryDiscovery extends ClassDiscovery
{
    /**
     * @var StreamFactory
     */
    protected static $cache;

    /**
     * @var array
     */
    protected static $classes = [
        'guzzle' => [
            'class'     => 'Http\Discovery\StreamFactory\GuzzleStreamFactory',
            'condition' => [
                'Http\Discovery\StreamFactory\GuzzleStreamFactory',
                'GuzzleHttp\Psr7\Stream',
            ],
        ],
        'diactoros' => [
            'class'     => 'Http\Discovery\StreamFactory\DiactorosStreamFactory',
            'condition' => [
                'Http\Discovery\StreamFactory\DiactorosStreamFactory',
                'Zend\Diactoros\Stream',
            ],
        ],
    ];

    /**
     * Finds a Stream Factory.
     *
     * @return StreamFactory
     *
     * @throws NotFoundException
     */
    public static function find()
    {
        // Override only used for return type declaration
        return parent::find();
    }
}
