<?php

namespace Http\Discovery;

use Http\Message\MessageFactory;

/**
 * Finds a Message Factory.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class MessageFactoryDiscovery extends FactoryDiscovery
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
            'class' => 'Http\Message\MessageFactory\GuzzleMessageFactory',
            'condition' => [
                'Http\Message\MessageFactory\GuzzleMessageFactory',
                'GuzzleHttp\Psr7\Request',
            ],
        ],
        'diactoros' => [
            'class' => 'Http\Message\MessageFactory\DiactorosMessageFactory',
            'condition' => [
                'Http\Message\MessageFactory\DiactorosMessageFactory',
                'Zend\Diactoros\Request',
            ],
        ],
    ];

    /**
     * Finds a Message Factory.
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
