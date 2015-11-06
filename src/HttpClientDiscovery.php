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

use Http\Client\HttpClient;

/**
 * Finds an HTTP Client
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class HttpClientDiscovery extends ClassDiscovery
{
    /**
     * @var HttpClient
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
        'guzzle5' => [
            'class'     => 'Http\Adapter\Guzzle5HttpAdapter',
            'condition' => 'Http\Adapter\Guzzle5HttpAdapter',
        ],
    ];

    /**
     * Finds an HTTP Client
     *
     * @return HttpClient
     *
     * @throws NotFoundException If no suitable client is available
     */
    public static function find()
    {
        // Override only used for return type declaration
        return parent::find();
    }
}
