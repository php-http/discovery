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

/**
 * Finds a Message Factory
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class MessageFactoryDiscovery
{
    /**
     * @var array
     */
    protected static $messageFactories = [
        'guzzle' => [
            'class'   => 'GuzzleHttp\Psr7\Request',
            'factory' => 'Http\Discovery\MessageFactory\GuzzleFactory',
        ],
        'diactoros' => [
            'class'   => 'Zend\Diactoros\Request',
            'factory' => 'Http\Discovery\MessageFactory\DiactorosFactory',
        ],
    ];

    /**
     * @var string
     */
    protected static $cache;

    /**
     * Register a Message Factory
     *
     * @param string $name
     * @param string $class
     * @param string $factory
     */
    public static function register($name, $class, $factory)
    {
        static::$cache = null;

        static::$messageFactories[$name] = [
            'class'   => $class,
            'factory' => $factory,
        ];
    }

    /**
     * Finds a Message Factory
     *
     * @return object
     *
     * @throws NotFoundException
     */
    public static function find()
    {
        // We have a cache
        if (isset(static::$cache)) {
            return static::$cache;
        }

        foreach (static::$messageFactories as $name => $definition) {
            if (class_exists($definition['class'])) {
                return static::$cache = new $definition['factory'];
            }
        }

        throw new NotFoundException('No Message Factory found');
    }
}
