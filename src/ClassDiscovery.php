<?php

namespace Http\Discovery;

use Puli\Discovery\Api\Discovery;

/**
 * Registry that based find results on class existence.
 *
 * @author David de Boer <david@ddeboer.nl>
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class ClassDiscovery
{
    /**
     * @var GeneratedPuliFactory
     */
    private static $puliFactory;

    /**
     * @var Discovery
     */
    private static $puliDiscovery;

    /**
     * @return GeneratedPuliFactory
     */
    public static function getPuliFactory()
    {
        if (null === self::$puliFactory) {
            if (!defined('PULI_FACTORY_CLASS')) {
                throw new \RuntimeException('Puli Factory is not available');
            }

            $puliFactoryClass = PULI_FACTORY_CLASS;

            if (!class_exists($puliFactoryClass)) {
                throw new \RuntimeException('Puli Factory class does not exist');
            }

            self::$puliFactory = new $puliFactoryClass();
        }

        return self::$puliFactory;
    }

    /**
     * Sets the Puli factory.
     *
     * @param object $puliFactory
     */
    public static function setPuliFactory($puliFactory)
    {
        if (!is_callable([$puliFactory, 'createRepository']) || !is_callable([$puliFactory, 'createDiscovery'])) {
            throw new \InvalidArgumentException('The Puli Factory must expose a repository and a discovery');
        }

        self::$puliFactory = $puliFactory;
        self::$puliDiscovery = null;
    }

    /**
     * Resets the factory.
     */
    public static function resetPuliFactory()
    {
        self::$puliFactory = null;
        self::$puliDiscovery = null;
    }

    /**
     * Returns the Puli discovery layer.
     *
     * @return Discovery
     */
    public static function getPuliDiscovery()
    {
        if (!isset(self::$puliDiscovery)) {
            $factory = self::getPuliFactory();
            $repository = $factory->createRepository();

            self::$puliDiscovery = $factory->createDiscovery($repository);
        }

        return self::$puliDiscovery;
    }

    /**
     * Finds a class.
     *
     * @param $type
     *
     * @return string
     *
     * @throws NotFoundException
     */
    public static function findOneByType($type)
    {
        $bindings = self::getPuliDiscovery()->findBindings($type);

        foreach ($bindings as $binding) {
            if ($binding->hasParameterValue('depends')) {
                $dependency = $binding->getParameterValue('depends');

                if (!self::evaluateCondition($dependency)) {
                    continue;
                }
            }

            // TODO: check class binding
            return $binding->getClassName();
        }

        throw new NotFoundException(sprintf('Resource of type "%s" not found', $type));
    }

    /**
     * Finds a resource.
     *
     * @return object
     */
    public static function find()
    {
        throw new \LogicException('Not implemented');
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
