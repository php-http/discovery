<?php

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
