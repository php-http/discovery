<?php

/*
 * This file is part of the Http Discovery package.
 *
 * (c) PHP HTTP Team <team@php-http.org>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Discovery;

use Http\Message\StreamFactory;

/**
 * Finds a Stream Factory
 *
 * @author Михаил Красильников <m.krasilnikov@yandex.ru>
 */
class StreamFactoryDiscovery extends ClassDiscovery
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
            'condition' => 'GuzzleHttp\Psr7\Stream',
        ],
        'diactoros' => [
            'class'     => 'Http\Discovery\StreamFactory\DiactorosStreamFactory',
            'condition' => 'Zend\Diactoros\Stream',
        ],
    ];

    /**
     * Finds a Stream Factory
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
