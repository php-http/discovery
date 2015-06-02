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
 * Finds an HTTP Adapter
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class HttpAdapterDiscovery
{
    /**
     * @var array
     */
    protected static $adapters = [
        'guzzle6' => 'Http\Adapter\Guzzle6HttpAdapter',
        'guzzle5' => 'Http\Adapter\Guzzle5HttpAdapter',
    ];

    /**
     * @var string
     */
    protected static $cache;

    /**
     * Register an HTTP Adapter
     *
     * @param string $name
     * @param string $class
     */
    public static function register($name, $class)
    {
        static::$cache = null;

        static::$adapters[$name] = $class;
    }

    /**
     * Finds an HTTP Adapter
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

        foreach (static::$adapters as $name => $class) {
            if (class_exists($class)) {
                return static::$cache = new $class;
            }
        }

        throw new NotFoundException('No HTTP Adapter found');
    }
}
