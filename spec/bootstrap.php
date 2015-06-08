<?php

// Used for real return type check

if (!interface_exists('Http\Adapter\HttpAdapter')) {
    eval('namespace Http\Adapter; interface HttpAdapter {}');
}

if (!class_exists('Http\Adapter\Guzzle6HttpAdapter')) {
    eval('namespace Http\Adapter; class Guzzle6HttpAdapter implements HttpAdapter {}');
}

