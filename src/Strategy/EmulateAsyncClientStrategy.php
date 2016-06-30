<?php

namespace Http\Discovery\Strategy;

use Http\Adapter\Guzzle6\Client as Guzzle6;
use Http\Adapter\Guzzle5\Client as Guzzle5;
use Http\Client\Common\EmulatedHttpAsyncClient;
use Http\Client\Curl\Client as Curl;
use Http\Client\Socket\Client as Socket;
use Http\Adapter\React\Client as React;
use Http\Adapter\Buzz\Client as Buzz;

/**
 * @internal
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class EmulateAsyncClientStrategy implements DiscoveryStrategy
{
    /**
     * {@inheritdoc}
     */
    public static function getCandidates($type)
    {
        if ($type === 'Http\Client\HttpAsyncClient') {
            return [
            //     ['class' => Guzzle6::class, 'condition' => Guzzle6::class],
            //     ['class' => Curl::class, 'condition' => Curl::class],
            //     ['class' => React::class, 'condition' => React::class],
                ['class' => function() { return new EmulatedHttpAsyncClient(new Guzzle5()); }, 'condition' => Guzzle5::class],
                ['class' => function() { return new EmulatedHttpAsyncClient(new Socket()); }, 'condition' => Socket::class],
                ['class' => function() { return new EmulatedHttpAsyncClient(new Buzz()); }, 'condition' => Buzz::class],
            ];
        }

        return [];
    }
}
