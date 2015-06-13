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

use Http\Adapter\HttpAdapter;

/**
 * Finds an HTTP Adapter
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class HttpAdapterDiscovery extends ClassDiscovery
{
    /**
     * @var HttpAdapter
     */
    protected static $cache;

    /**
     * @var array
     */
    protected static $classes = [
        'guzzle6' => [
            'class'     => 'Http\Adapter\Guzzle6HttpAdapter',
            'condition' => 'Http\Adapter\Guzzle6HttpAdapter'

        ],
        'guzzle5' => [
            'class'     => 'Http\Adapter\Guzzle5HttpAdapter',
            'condition' => 'Http\Adapter\Guzzle5HttpAdapter'
        ],
    ];

    /**
     * Finds an HTTP Adapter
     *
     * @return HttpAdapter
     *
     * @throws NotFoundException
     */
    public static function find()
    {
        // Override only used for return type declaration
        return parent::find();
    }
}
