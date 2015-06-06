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

use Http\Message\UriFactory;

/**
 * Finds a URI Factory
 *
 * @author David de Boer <david@ddeboer.nl>
 */
class UriFactoryDiscovery extends ClassDiscovery
{
    /**
     * @var UriFactory
     */
    protected static $cache;

    /**
     * @var array
     */
    protected static $classes = [
        'guzzle' => [
            'class'     => 'Http\Discovery\UriFactory\GuzzleFactory',
            'condition' => 'GuzzleHttp\Psr7\Uri',
        ],
        'diactoros' => [
            'class'     => 'Http\Discovery\UriFactory\DiactorosFactory',
            'condition' => 'Zend\Diactoros\Uri',
        ],
    ];

    /**
     * Finds a URI Factory
     *
     * @return UriFactory
     */
    public static function find()
    {
        // Override only used for return type declaration
        return parent::find();
    }
}
