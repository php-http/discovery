<?php

namespace Http\Discovery\FallbackStrategy;

/**
 * Find Diactoros factories.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class DiactorosFactory implements FallbackStrategy
{
    /**
     * {@inheritdoc}
     */
    public static function findOneByType($type)
    {
        if (!class_exists('Zend\Diactoros\Request')) {
            return false;
        }

        switch ($type) {
            case 'Http\Message\MessageFactory':
                if (class_exists('Http\Message\MessageFactory\DiactorosMessageFactory')) {
                    return 'Http\Message\MessageFactory\DiactorosMessageFactory';
                }
                break;
            case 'Http\Message\StreamFactory':
                if (class_exists('Http\Message\StreamFactory\DiactorosStreamFactory')) {
                    return 'Http\Message\StreamFactory\DiactorosStreamFactory';
                }
                break;
            case 'Http\Message\UriFactory':
                if (class_exists('Http\Message\UriFactory\DiactorosUriFactory')) {
                    return 'Http\Message\UriFactory\DiactorosUriFactory';
                }
                break;
        }

        return false;
    }
}
