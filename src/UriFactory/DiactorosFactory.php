<?php

namespace Http\Discovery\UriFactory;

use Zend\Diactoros\Uri;
use Http\Message\UriFactory;

/**
 * Creates a zend/diactoros URI object
 *
 * @author David de Boer <david@ddeboer.nl>
 */
class DiactorosFactory implements UriFactory
{
    /**
     * {@inheritdoc}
     */
    public function createUri($uri)
    {
        return new Uri($uri);
    }
}
