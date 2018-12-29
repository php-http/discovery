<?php

namespace Http\Discovery\Strategy;

use Http\Message\MessageFactory;
use Http\Message\StreamFactory;
use Http\Message\UriFactory;
use Nyholm\Psr7\Factory\MessageFactory as NyholmMessageFactory;
use Nyholm\Psr7\Factory\StreamFactory as NyholmStreamFactory;
use Nyholm\Psr7\Factory\UriFactory as NyholmUriFactory;

/**
 * Discover classes that are deprecated and no longer should be supported.
 *
 * @internal
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class DeprecatedClassesStrategy implements DiscoveryStrategy
{
    private static $classes = [
        MessageFactory::class => [
            ['class' => NyholmMessageFactory::class, 'condition' => [NyholmRequest::class, NyholmMessageFactory::class]],
        ],
        StreamFactory::class => [
            ['class' => NyholmStreamFactory::class, 'condition' => [NyholmRequest::class, NyholmStreamFactory::class]],
        ],
        UriFactory::class => [
            ['class' => NyholmUriFactory::class, 'condition' => [NyholmRequest::class, NyholmUriFactory::class]],
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public static function getCandidates($type)
    {
        if (isset(self::$classes[$type])) {
            return self::$classes[$type];
        }

        return [];
    }
}
