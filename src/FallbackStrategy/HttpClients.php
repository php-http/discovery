<?php

namespace Http\Discovery\FallbackStrategy;

/**
 * Find common HTTP clients.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class HttpClients implements FallbackStrategy
{
    /**
     * {@inheritdoc}
     */
    public static function findOneByType($type)
    {
        switch ($type) {
            case 'Http\Client\HttpAsyncClient':
                $clients = ['Http\Adapter\Guzzle6\Client'];
                foreach ($clients as $class) {
                    if (class_exists($class)) {
                        return $class;
                    }
                }
                break;
            case 'Http\Client\HttpClient':
                $clients = ['Http\Adapter\Guzzle6\Client', 'Http\Adapter\Guzzle5\Client'];
                foreach ($clients as $class) {
                    if (class_exists($class)) {
                        return $class;
                    }
                }
                break;
        }

        return false;
    }
}
