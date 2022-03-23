<?php

declare(strict_types=1);

namespace IW\PHPStan\Reflection;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptor;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

/**
 * Reflect magic enum method
 */
class EnumMethodReflection implements MethodReflection
{
    private ClassReflection $classReflection;

    private string $methodName;

    /** @var FunctionVariant[] */
    private array $variants;

    /**
     * Constructor
     *
     * @param ClassReflection $classReflection Declaring class for the reflected method
     * @param string          $methodName      Name of method
     */
    public function __construct(ClassReflection $classReflection, string $methodName)
    {
        $this->classReflection = $classReflection;
        $this->methodName      = $methodName;
        $this->variants        = [
            new FunctionVariant(
                TemplateTypeMap::createEmpty(),
                null,
                $this->getParameters(),
                $this->isVariadic(),
                $this->getReturnType()
            ),
        ];
    }

    /**
     * Gets declaring class for the reflected method
     */
    public function getDeclaringClass(): ClassReflection
    {
        return $this->classReflection;
    }

    /**
     * Gets the method prototype
     */
    public function getPrototype(): ClassMemberReflection
    {
        return $this;
    }

    /**
     * Checks if method is static
     */
    public function isStatic(): bool
    {
        return true;
    }

    /**
     * Checks if method is private
     */
    public function isPrivate(): bool
    {
        return false;
    }

    /**
     * Checks if method is public
     */
    public function isPublic(): bool
    {
        return true;
    }

    /**
     * Gets method name
     */
    public function getName(): string
    {
        return $this->methodName;
    }

    /**
     * Gets parameters
     *
     * @return ParameterReflection[]
     */
    public function getParameters(): array
    {
        return [];
    }

    public function isVariadic(): bool
    {
        return false;
    }

    public function getReturnType(): Type
    {
        return new ObjectType($this->classReflection->getName());
    }

    /**
     * @return ParametersAcceptor[]
     */
    public function getVariants(): array
    {
        return $this->variants;
    }

    public function isDeprecated(): TrinaryLogic
    {
        return TrinaryLogic::createNo();
    }

    public function getDeprecatedDescription(): ?string
    {
        return null;
    }

    public function isFinal(): TrinaryLogic
    {
        return TrinaryLogic::createNo();
    }

    public function isInternal(): TrinaryLogic
    {
        return TrinaryLogic::createNo();
    }

    public function getThrowType(): ?Type
    {
        return null;
    }

    public function hasSideEffects(): TrinaryLogic
    {
        return TrinaryLogic::createNo();
    }

    public function getDocComment(): ?string
    {
        return null;
    }
}
