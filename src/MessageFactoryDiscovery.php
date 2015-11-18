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

use Http\Message\MessageFactory;

/**
 * Finds a Message Factory
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class MessageFactoryDiscovery extends ClassDiscovery
{
    /**
     * @var MessageFactory
     */
    protected static $cache;

    /**
     * @var array
     */
    protected static $classes = [
        'guzzle' => [
            'class'     => 'Http\Discovery\MessageFactory\GuzzleFactory',
            'condition' => 'GuzzleHttp\Psr7\Request',
        ],
        'diactoros' => [
            'class'     => 'Http\Discovery\MessageFactory\DiactorosFactory',
            'condition' => 'Zend\Diactoros\Request',
        ],
    ];

    /**
     * Finds a Message Factory
     *
     * @return MessageFactory
     *
     * @throws NotFoundException
     */
    public static function find()
    {
        // Override only used for return type declaration
        return parent::find();
    }
}
