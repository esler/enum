<?php declare(strict_types=1);

namespace IW;

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
 *
 * @author Ondrej Esler <ondrej.esler@intraworlds.com>
 */
abstract class Enum
{
    /** @var string */
    private $key;

    /** @var mixed */
    private $_value;

    /** @var array */
    private static $_singletons = [];

    /**
     * Constructor
     *
     * @param string $key
     */
    final private function __construct(string $key) {
        if (!defined(static::class . '::' . $key)) {
            throw new \InvalidArgumentException('Unknown constant: ' . static::class . '::' . $key);
        }

        $this->key   = $key;
        $this->value = \constant(static::class . '::' . $key);
    }

    /**
     * Map class constants to static methods const FOO => FOO(), returns singleton of an enum with value of constant
     *
     * @param string $key
     * @param array  $arguments
     *
     * @return Enum
     */
    final public static function __callStatic(string $key, array $arguments): Enum {
        $singletonId = static::class . $key;

        if (empty(self::$_singletons[$singletonId])) {
            self::$_singletons[$singletonId] = new static($key);
        }

        return self::$_singletons[$singletonId];
    }

    /**
     * Returns string representation of constant value
     *
     * @return string
     */
    final public function __toString(): string {
        return is_array($this->value) ? json_encode($this->value) : (string) $this->value;
    }

    /**
     * Return TRUE if given enum is the same, FALSE otherwise
     *
     * @param Enum $enum
     *
     * @return bool
     */
    final public function equals(Enum $enum): bool {
        return $this === $enum;
    }

    /**
     * Returns name of constant
     *
     * @return string
     */
    final public function getKey(): string {
        return $this->key;
    }

    /**
     * Returns value of constant
     *
     * @return mixed
     */
    final public function getValue() {
        return $this->value;
    }

    /**
     * Returns list of names of constants
     *
     * @return string[]
     */
    final public static function keys(): array {
        return array_keys(static::toArray());
    }

    /**
     * Returns list of values of constants
     *
     * @return mixed[]
     */
    final public static function values(): array {
        return array_values(static::toArray());
    }

    /**
     * Returns array with all constants eg. [key => value, ...]
     *
     * @return mixed[]
     */
    final public static function toArray(): array {
        return (new \ReflectionClass(static::class))->getConstants();
    }

}
