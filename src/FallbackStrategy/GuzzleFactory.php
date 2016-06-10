<?php

namespace Http\Discovery\FallbackStrategy;

/**
 * Find Guzzle factories.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class GuzzleFactory implements FallbackStrategy
{
    /**
     * {@inheritdoc}
     */
    public static function findOneByType($type)
    {
        if (!class_exists('GuzzleHttp\Psr7\Request')) {
            return false;
        }

        switch ($type) {
            case 'Http\Message\MessageFactory':
                if (class_exists('Http\Message\MessageFactory\GuzzleMessageFactory')) {
                    return 'Http\Message\MessageFactory\GuzzleMessageFactory';
                }
                break;
            case 'Http\Message\StreamFactory':
                if (class_exists('Http\Message\StreamFactory\GuzzleStreamFactory')) {
                    return 'Http\Message\StreamFactory\GuzzleStreamFactory';
                }
                break;
            case 'Http\Message\UriFactory':
                if (class_exists('Http\Message\UriFactory\GuzzleUriFactory')) {
                    return 'Http\Message\UriFactory\GuzzleUriFactory';
                }
                break;
        }

        return false;
    }
}
