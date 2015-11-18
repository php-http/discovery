<?php

/*
 * This file is part of the Http Discovery package.
 *
 * (c) PHP HTTP Team <team@php-http.org>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Discovery\MessageFactory;

use Http\Discovery\StreamFactory\DiactorosStreamFactory;
use Http\Message\MessageFactory;
use Psr\Http\Message\StreamInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
final class DiactorosFactory implements MessageFactory
{
    /**
     * @var DiactorosStreamFactory
     */
    private $streamFactory;

    public function __construct()
    {
        $this->streamFactory = new DiactorosStreamFactory();
    }

    /**
     * {@inheritdoc}
     */
    public function createRequest(
        $method,
        $uri,
        array $headers = [],
        $body = null,
        $protocolVersion = '1.1'
    ) {
        return (new Request(
            $uri,
            $method,
            $this->streamFactory->createStream($body),
            $headers
        ))->withProtocolVersion($protocolVersion);
    }

    /**
     * {@inheritdoc}
     */
    public function createResponse(
        $statusCode = 200,
        $reasonPhrase = null,
        array $headers = [],
        $body = null,
        $protocolVersion = '1.1'
    ) {
        return (new Response(
            $this->streamFactory->createStream($body),
            $statusCode,
            $headers
        ))->withProtocolVersion($protocolVersion);
    }
}
