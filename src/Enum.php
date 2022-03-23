<?php

declare(strict_types=1);

namespace IW;

use InvalidArgumentException;
use JsonSerializable;
use ReflectionClass;
use function array_keys;
use function array_values;
use function constant;
use function defined;
use function is_array;
use function json_encode;

/**
 * Base for enum-like value object, it defines static methods with same names as constants which returns singleton
 * of particular enum and its value.
 *
 * Implementation is simpler version of library https://packagist.org/packages/myclabs/php-enum with added singletons
 * to be able use strict equals.
 *
 * Examples:
 *
 * final class Hash extends Enum
 * {
 *   const MD5 = 'md5';
 *   const SHA1 = 'sha1';
 * }
 *
 * $a = Hash::MD5();
 * var_dump($a === Hash::MD5());
 * > true
 *
 * // ALWAYS use strict equal! see the problem
 * var_dump($a == Hash::SHA1());
 * > true
 *
 * var_dump($a->getValue() === Hash::MD5);
 * > true
 *
 * function crack(Hash $hash) {
 *   echo 'cracking ... ' . $hash;
 * }
 *
 * crack(Hash::SHA1());
 * > cracking ... sha1
 * crack(Hash::SHA1);
 * > throws TypeError
 *
 * switch ($a->getValue()) {
 *   case Hash::MD5: ...
 *   case Hash::SHA1: ...
 * }
 */
abstract class Enum implements JsonSerializable
{
    private string $key;

    private mixed $value;

    /** @var static[] */
    private static array $singletons = [];

    /**
     * Constructor
     */
    final private function __construct(string $key)
    {
        if (! defined(static::class . '::' . $key)) {
            throw new InvalidArgumentException('Unknown constant: ' . static::class . '::' . $key);
        }

        $this->key   = $key;
        $this->value = constant(static::class . '::' . $key);
    }

    /**
     * Map class constants to static methods const FOO => FOO(), returns singleton of an enum with value of constant
     *
     * @param mixed[] $arguments
     */
    final public static function __callStatic(string $key, array $arguments): Enum
    {
        $singletonId = static::class . $key;

        if (empty(self::$singletons[$singletonId])) {
            self::$singletons[$singletonId] = new static($key);
        }

        return self::$singletons[$singletonId];
    }

    /**
     * Returns string representation of constant value
     */
    final public function __toString(): string
    {
        return is_array($this->value) && ($json = json_encode($this->value)) ? $json : (string) $this->value;
    }

    /**
     * Return TRUE if given enum is the same, FALSE otherwise
     */
    final public function equals(Enum $enum): bool
    {
        return $this === $enum;
    }

    /**
     * Search for Enum instance by its value or NULL if nothing found
     *
     * @param mixed $for a value to search for
     */
    final public static function search(mixed $for): ?static
    {
        foreach (static::toArray() as $key => $value) {
            if ($value === $for) {
                return static::__callStatic($key, []);
            }
        }

        return null;
    }

    /**
     * Returns name of constant
     */
    final public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Returns value of constant
     */
    final public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Returns value for JSON serialization
     */
    final public function jsonSerialize(): mixed
    {
        return $this->value;
    }

    /**
     * Returns list of names of constants
     *
     * @return string[]
     */
    final public static function keys(): array
    {
        return array_keys(static::toArray());
    }

    /**
     * Returns list of values of constants
     *
     * @return mixed[]
     */
    final public static function values(): array
    {
        return array_values(static::toArray());
    }

    /**
     * Returns array with all constants eg. [key => value, ...]
     *
     * @return mixed[]
     */
    final public static function toArray(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }
}
