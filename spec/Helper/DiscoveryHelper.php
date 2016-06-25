<?php

namespace spec\Http\Discovery\Helper;

use Http\Discovery\Strategy\DiscoveryStrategy;

/**
 * This is a discovery helper used in tests
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class DiscoveryHelper implements DiscoveryStrategy
{
    private static $classes = [];

    /**
     * @param string $type
     * @param array $classes
     *
     * @return $this
     */
    public static function setClasses($type, array $classes)
    {
        self::$classes[$type] = $classes;
    }

    /**
     * Clear all classes.
     */
    public static function clearClasses()
    {
        self::$classes = [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getCandidates($type)
    {
        if (isset(static::$classes[$type])) {
            return static::$classes[$type];
        }

        return [];
    }
}
