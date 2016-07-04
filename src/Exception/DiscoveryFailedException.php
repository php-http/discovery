<?php

namespace Http\Discovery\Exception;

use Http\Discovery\Exception;

/**
 * Thrown when all discovery strategies fails to find a resource.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class DiscoveryFailedException extends \Exception implements Exception
{
    /**
     * @var array
     */
    private $exceptions;

    /**
     * @param $exceptions
     */
    public function __construct($message, array $exceptions = [])
    {
        $this->exceptions = $exceptions;

        parent::__construct($message, 0, array_shift($exceptions));
    }

    /**
     * @return array
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }
}
