<?php

namespace Http\Discovery;

use Http\Message\UriFactory;

/**
 * Finds a URI Factory.
 *
 * @author David de Boer <david@ddeboer.nl>
 */
final class UriFactoryDiscovery extends FactoryDiscovery
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
            'class' => 'Http\Client\Utils\UriFactory\GuzzleUriFactory',
            'condition' => [
                'Http\Client\Utils\UriFactory\GuzzleUriFactory',
                'GuzzleHttp\Psr7\Uri',
            ],
        ],
        'diactoros' => [
            'class' => 'Http\Client\Utils\UriFactory\DiactorosUriFactory',
            'condition' => [
                'Http\Client\Utils\UriFactory\DiactorosUriFactory',
                'Zend\Diactoros\Uri',
            ],
        ],
    ];

    /**
     * Finds a URI Factory.
     *
     * @return UriFactory
     */
    public static function find()
    {
        // Override only used for return type declaration
        return parent::find();
    }
}
