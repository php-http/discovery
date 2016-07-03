<?php

namespace Http\Discovery;

@trigger_error('The '.__NAMESPACE__.'\NotFoundException class is deprecated since version 1.0 and will be removed in 2.0. Use Http\Discovery\Exception\NotFoundException instead.', E_USER_DEPRECATED);

/**
 * Thrown when a discovery does not find any matches.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @deprecated since since version 1.0, and will be removed in 2.0. Use {@link \Http\Discovery\Exception\NotFoundException} instead.
 */
final class NotFoundException extends \Http\Discovery\Exception\NotFoundException
{
}
