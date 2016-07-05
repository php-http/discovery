<?php

namespace spec\Http\Discovery\Helper;

use Http\Discovery\Strategy\DiscoveryStrategy;

/**
 * This is a discovery helper used in tests. It will always pass a class named "Sucess"
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class SuccessfullDiscoveryStrategy implements DiscoveryStrategy
{
    /**
     * {@inheritdoc}
     */
    public static function getCandidates($type)
    {
        return [['class'=>'Success']];
    }
}
