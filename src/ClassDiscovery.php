<?php

namespace Http\Discovery;

/**
 * Registry that based find results on class existence.
 *
 * @author David de Boer <david@ddeboer.nl>
 */
abstract class ClassDiscovery
{
    /**
     * Add a class (and condition) to the discovery registry.
     *
     * @param string $class     Class that will be instantiated if found
     * @param string $condition Optional other class to check for existence
     */
    public static function register($class, $condition = null)
    {
        static::$cache = null;

        $definition = [
            'class' => $class,
            'condition' => isset($condition) ? $condition : $class,
        ];

        array_unshift(static::$classes, $definition);
    }

    /**
     * Finds a Class.
     *
     * @return object
     *
     * @throws NotFoundException
     */
    public static function find()
    {
        // We have a cache
        if (isset(static::$cache)) {
            return new static::$cache();
        }

        foreach (static::$classes as $name => $definition) {
            if (static::evaluateCondition($definition['condition'])) {
                static::$cache = $definition['class'];

                return new $definition['class']();
            }
        }

        throw new NotFoundException('Not found');
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
