<?php declare(strict_types=1);

namespace OpenSerializer\Type;

use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionProperty;

final class TypedPropertyResolver implements PropertyTypeResolver
{
    /**
     * @param ReflectionClass<object> $class
     */
    public function resolveType(ReflectionClass $class, ReflectionProperty $property): TypeInfo
    {
        $type = $property->getType();

        if (!$type instanceof ReflectionNamedType) {
            return TypeInfo::ofMixed();
        }

        $isNullable = $type->allowsNull();

        if (!$type->isBuiltin()) {
            return TypeInfo::ofObject($type->getName(), $isNullable);
        }

        return TypeInfo::ofBuiltIn($type->getName(), $isNullable);
    }

    /**
     * @param ReflectionClass<object> $class
     */
    public function resolveMethodType(ReflectionClass $class, ReflectionMethod $method): TypeInfo
    {
        $type = $method->getReturnType();

        if (!$type instanceof ReflectionNamedType) {
            return TypeInfo::ofMixed();
        }

        $isNullable = $type->allowsNull();

        if (!$type->isBuiltin()) {
            return TypeInfo::ofObject($type->getName(), $isNullable);
        }

        return TypeInfo::ofBuiltIn($type->getName(), $isNullable);
    }
}
