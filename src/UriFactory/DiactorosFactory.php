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

use Http\Message\UriFactory;
use Psr\Http\Message\UriInterface;
use Zend\Diactoros\Uri;

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
        if ($uri instanceof UriInterface) {
            return $uri;
        } elseif (is_string($uri)) {
            return new Uri($uri);
        }

        throw new \InvalidArgumentException('URI must be a string or UriInterface');
    }
}
