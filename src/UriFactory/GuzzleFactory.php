<?php

/*
 * This file is part of the Http Discovery package.
 *
 * (c) PHP HTTP Team <team@php-http.org>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Discovery\UriFactory;

use GuzzleHttp\Psr7;
use Http\Message\UriFactory;

/**
 * Creates a guzzlehttp/psr7 URI object
 *
 * @author David de Boer <david@ddeboer.nl>
 */
class GuzzleFactory implements UriFactory
{
    /**
     * {@inheritdoc}
     */
    public function createUri($uri)
    {
        return Psr7\uri_for($uri);
    }
}
