<?php

namespace Http\Discovery;

use Http\Discovery\Exception\DiscoveryFailedException;
use Http\Discovery\Exception\StrategyUnavailableException;

/**
 * Registry that based find results on class existence.
 *
 * @author David de Boer <david@ddeboer.nl>
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
abstract class ClassDiscovery
{
    /**
     * A list of strategies to find classes.
     *
     * @var array
     */
    private static $strategies = [
        Strategy\Puli::class,
        Strategy\CommonClassesStrategy::class,
    ];

    /**
     * Discovery cache to make the second time we use discovery faster.
     *
     * @var array
     */
    private static $cache = [];

    /**
     * Finds a class.
     *
     * @param string $type
     *
     * @return string
     *
     * @throws DiscoveryFailedException
     */
    protected static function findOneByType($type)
    {
        // Look in the cache
        if (null !== ($class = self::getFromCache($type))) {
            return $class;
        }

        $exceptions = [];
        foreach (self::$strategies as $strategy) {
            try {
                $candidates = call_user_func($strategy.'::getCandidates', $type);
            } catch (StrategyUnavailableException $e) {
                $exceptions[] = $e;
                continue;
            }

            foreach ($candidates as $candidate) {
                if (isset($candidate['condition'])) {
                    if (!self::evaluateCondition($candidate['condition'])) {
                        continue;
                    }
                }

                // save the result for later use
                self::storeInCache($type, $candidate);

                return $candidate['class'];
            }
        }

        throw new DiscoveryFailedException('Could not find resource using any discovery strategy', $exceptions);
    }

    /**
     * Get a value from cache.
     *
     * @param string $type
     *
     * @return string|null
     */
    private static function getFromCache($type)
    {
        if (!isset(self::$cache[$type])) {
            return;
        }

        $candidate = self::$cache[$type];
        if (!self::evaluateCondition($candidate['condition'])) {
            return;
        }

        return $candidate['class'];
    }

    /**
     * Store a value in cache.
     *
     * @param string $type
     * @param string $class
     */
    private static function storeInCache($type, $class)
    {
        self::$cache[$type] = $class;
    }

    /**
     * Set new strategies and clear the cache.
     *
     * @param array $strategies
     */
    public static function setStrategies(array $strategies)
    {
        self::$strategies = $strategies;
        self::clearCache();
    }

    /**
     * Clear the cache.
     */
    public static function clearCache()
    {
        self::$cache = [];
    }

    /**
     * Evaulates conditions to boolean.
     *
     * @param mixed $condition
     *
     * @return bool
     */
    protected static function evaluateCondition($condition)
    {
        if (is_string($condition)) {
            // Should be extended for functions, extensions???
            return class_exists($condition);
        } elseif (is_callable($condition)) {
            return $condition();
        } elseif (is_bool($condition)) {
            return $condition;
        } elseif (is_array($condition)) {
            $evaluatedCondition = true;

            // Immediately stop execution if the condition is false
            for ($i = 0; $i < count($condition) && false !== $evaluatedCondition; ++$i) {
                $evaluatedCondition &= static::evaluateCondition($condition[$i]);
            }

            return $evaluatedCondition;
        }

        return false;
    }
}
