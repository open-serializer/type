<?php declare(strict_types=1);

namespace OpenSerializer\Type\Tests;

use OpenSerializer\Type\DocBlockPropertyResolver;
use OpenSerializer\Type\PropertyTypeResolvers;
use OpenSerializer\Type\TypedPropertyResolver;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class PropertyTypeResolversTest extends TestCase
{
    function test_()
    {
        $typeResolver = new PropertyTypeResolvers(
            new TypedPropertyResolver(),
            new DocBlockPropertyResolver(),
        );

        $classInfo = new ReflectionClass(Foo::class);
        $methodInfo = $classInfo->getMethod('test');
        $typeInfo = $typeResolver->resolveMethodType($classInfo, $methodInfo);

        self::assertEquals(true, $typeInfo->isArray());
        self::assertEquals(true, $typeInfo->innerType()->isInteger());
    }
}
