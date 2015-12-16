<?php

namespace Http\Discovery;

use Http\Message\StreamFactory;

/**
 * Finds a Stream Factory.
 *
 * @author Михаил Красильников <m.krasilnikov@yandex.ru>
 */
final class StreamFactoryDiscovery extends FactoryDiscovery
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
            'class' => 'Http\Client\Utils\StreamFactory\GuzzleStreamFactory',
            'condition' => [
                'Http\Client\Utils\StreamFactory\GuzzleStreamFactory',
                'GuzzleHttp\Psr7\Stream',
            ],
        ],
        'diactoros' => [
            'class' => 'Http\Client\Utils\StreamFactory\DiactorosStreamFactory',
            'condition' => [
                'Http\Client\Utils\StreamFactory\DiactorosStreamFactory',
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
