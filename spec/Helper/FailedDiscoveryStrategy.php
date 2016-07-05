<?php

namespace spec\Http\Discovery\Helper;

use Http\Discovery\Strategy\DiscoveryStrategy;

/**
 * This is a discovery helper used in tests. It will always pass an empty array of candidates.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class FailedDiscoveryStrategy implements DiscoveryStrategy
{
    /**
     * {@inheritdoc}
     */
    public static function getCandidates($type)
    {
        return [];
    }
}
