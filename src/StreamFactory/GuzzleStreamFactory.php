<?php

/*
 * This file is part of the Http Discovery package.
 *
 * (c) PHP HTTP Team <team@php-http.org>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Discovery\StreamFactory;

use Http\Message\StreamFactory;
use Psr\Http\Message\StreamInterface;

/**
 * @author Михаил Красильников <m.krasilnikov@yandex.ru>
 */
class GuzzleStreamFactory implements StreamFactory
{
    /**
     * Creates a stream
     *
     * @param string|resource|StreamInterface|null $body
     *
     * @return StreamInterface
     *
     * @throws \InvalidArgumentException if the $body arg is not valid.
     */
    public function createStream($body = null)
    {
        return \GuzzleHttp\Psr7\stream_for($body);
    }
}
