<?php

namespace Http\Discovery\Exception;

use Http\Discovery\Exception;

/**
 * Thrown when a class fails to instantiate.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ClassinstantiationFailedException extends \RuntimeException implements Exception
{
}
