<?php

namespace Http\Discovery\Strategy;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * @internal
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class CommonPsr17ClassesStrategy implements DiscoveryStrategy
{
    /**
     * @var array
     */
    private static $classes = [
        RequestFactoryInterface::class => [
            'Nyholm\Psr7\Factory\Psr17Factory',
            'Zend\Diactoros\RequestFactory',
            'GuzzleHttp\Psr7\HttpFactory',
            'Http\Factory\Diactoros\RequestFactory',
            'Http\Factory\Guzzle\RequestFactory',
            'Http\Factory\Slim\RequestFactory',
            'Laminas\Diactoros\RequestFactory',
        ],
        ResponseFactoryInterface::class => [
            'Nyholm\Psr7\Factory\Psr17Factory',
            'Zend\Diactoros\ResponseFactory',
            'GuzzleHttp\Psr7\HttpFactory',
            'Http\Factory\Diactoros\ResponseFactory',
            'Http\Factory\Guzzle\ResponseFactory',
            'Http\Factory\Slim\ResponseFactory',
            'Laminas\Diactoros\ResponseFactory',
        ],
        ServerRequestFactoryInterface::class => [
            'Nyholm\Psr7\Factory\Psr17Factory',
            'Zend\Diactoros\ServerRequestFactory',
            'GuzzleHttp\Psr7\HttpFactory',
            'Http\Factory\Diactoros\ServerRequestFactory',
            'Http\Factory\Guzzle\ServerRequestFactory',
            'Http\Factory\Slim\ServerRequestFactory',
            'Laminas\Diactoros\ServerRequestFactory',
        ],
        StreamFactoryInterface::class => [
            'Nyholm\Psr7\Factory\Psr17Factory',
            'Zend\Diactoros\StreamFactory',
            'GuzzleHttp\Psr7\HttpFactory',
            'Http\Factory\Diactoros\StreamFactory',
            'Http\Factory\Guzzle\StreamFactory',
            'Http\Factory\Slim\StreamFactory',
            'Laminas\Diactoros\StreamFactory',
        ],
        UploadedFileFactoryInterface::class => [
            'Nyholm\Psr7\Factory\Psr17Factory',
            'Zend\Diactoros\UploadedFileFactory',
            'GuzzleHttp\Psr7\HttpFactory',
            'Http\Factory\Diactoros\UploadedFileFactory',
            'Http\Factory\Guzzle\UploadedFileFactory',
            'Http\Factory\Slim\UploadedFileFactory',
            'Laminas\Diactoros\UploadedFileFactory',
        ],
        UriFactoryInterface::class => [
            'Nyholm\Psr7\Factory\Psr17Factory',
            'Zend\Diactoros\UriFactory',
            'GuzzleHttp\Psr7\HttpFactory',
            'Http\Factory\Diactoros\UriFactory',
            'Http\Factory\Guzzle\UriFactory',
            'Http\Factory\Slim\UriFactory',
            'Laminas\Diactoros\UriFactory',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public static function getCandidates($type)
    {
        $candidates = [];
        if (isset(self::$classes[$type])) {
            foreach (self::$classes[$type] as $class) {
                $candidates[] = ['class' => $class, 'condition' => [$class]];
            }
        }

        return $candidates;
    }
}
