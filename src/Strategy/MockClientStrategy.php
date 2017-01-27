<?php

namespace Http\Discovery\Strategy;

use Http\Mock\Client as Mock;

/**
 * Find the Mock client.
 *
 * @internal
 * @final
 *
 * @author Sam Rapaport <me@samrapdev.com>
 */
final class MockClientStrategy implements DiscoveryStrategy
{
    /**
     * {@inheritdoc}
     */
    public static function getCandidates($type)
    {
        return ($type === 'Http\Client\HttpClient')
            ? ['class' => Mock::class, 'condition' => Mock::class]
            : [];
    }
}
