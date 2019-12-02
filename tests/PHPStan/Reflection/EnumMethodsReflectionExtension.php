<?php

namespace IW\PHPStan\Reflection;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;

/**
 * Resolve magic method for enum
 *
 * @author Bohuslav Simek <bohuslav.simek@intraworlds.com>
 * @author Ondrej Esler <ondrej.esler@intraworlds.com>
 */
class EnumMethodsReflectionExtension implements MethodsClassReflectionExtension
{

    /**
     * Resolve if some class has (provide) specified method
     *
     * @param ClassReflection $classReflection Class reflection
     * @param string          $methodName      Method name
     *
     * @return bool
     */
    public function hasMethod(ClassReflection $classReflection, string $methodName) : bool
    {
        return $classReflection->isSubclassOf('IW\Enum') && $classReflection->hasConstant($methodName);
    }

    /**
     * Get specified method reflection
     *
     * @param ClassReflection $classReflection Class reflection
     * @param string          $methodName      Method name
     *
     * @return MethodReflection
     */
    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection {
        return new EnumMethodReflection($classReflection, $methodName);
    }
}
