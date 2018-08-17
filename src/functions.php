<?php

namespace GuzzleHttp\Psr7;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * We want to do a "safe" version of PHP's "class_exists" because Magento has a bug
 * (or they call it a "feature"). Magento is throwing an exception if you do class_exists()
 * on a class that ends with "Factory" and if that file does not exits.
 *
 * This function will catch all potential exceptions and make sure it returns a boolean.
 *
 * @param string $class
 * @param boolean $autoload
 *
 * @return boolean
 */
function safe_class_exists($class, $autoload = true)
{
    try {
        return class_exists($class, $autoload);
    } catch (\Exception $e) {
        return false;
    }
}
