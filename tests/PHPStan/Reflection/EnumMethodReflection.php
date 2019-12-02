<?php

namespace IW\PHPStan\Reflection;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

/**
 * Reflect magic enum method
 *
 * @author Bohuslav Simek <bohuslav.simek@intraworlds.com>
 * @author Ondrej Esler <ondrej.esler@intraworlds.com>
 */
class EnumMethodReflection implements MethodReflection
{
    /** @var ClassReflection */
    private $classReflection;

    /** @var string */
    private $methodName;

    /** @var FunctionVariant[] */
    private $variants;

    /**
     * Constructor
     *
     * @param ClassReflection $classReflection Declaring class for the reflected method
     * @param string          $methodName      Name of method
     */
    public function __construct(ClassReflection $classReflection, string $methodName) {
        $this->classReflection = $classReflection;
        $this->methodName      = $methodName;
        $this->variants        = [
            new FunctionVariant(
                $this->getParameters(),
                $this->isVariadic(),
                $this->getReturnType()
            ),
        ];
    }

    /**
     * Gets declaring class for the reflected method
     *
     * @return ClassReflection
     */
    public function getDeclaringClass(): ClassReflection {
        return $this->classReflection;
    }

    /**
     * Gets the method prototype
     *
     * @return ClassMemberReflection
     */
    public function getPrototype(): ClassMemberReflection {
        return $this;
    }

    /**
     * Checks if method is static
     *
     * @return bool
     */
    public function isStatic(): bool {
        return true;
    }

    /**
     * Checks if method is private
     *
     * @return bool
     */
    public function isPrivate(): bool {
        return false;
    }

    /**
     * Checks if method is public
     *
     * @return bool
     */
    public function isPublic(): bool {
        return true;
    }

    /**
     * Gets method name
     *
     * @return string
     */
    public function getName(): string {
        return $this->methodName;
    }

    /**
     * Gets parameters
     *
     * @return \PHPStan\Reflection\ParameterReflection[]
     */
    public function getParameters(): array {
        return [];
    }

    public function isVariadic(): bool {
        return false;
    }

    public function getReturnType(): Type {
        return new ObjectType($this->classReflection->getName());
    }

    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants(): array {
        return $this->variants;
    }
}
