<?php

namespace Http\Discovery\FallbackStrategy;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
interface FallbackStrategy
{
    /**
     * @param $type
     *
     * @return string|bool class name of boolean false
     */
    public static function findOneByType($type);
}
