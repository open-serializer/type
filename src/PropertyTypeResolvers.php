<?php declare(strict_types=1);

namespace OpenSerializer\Type;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

final class PropertyTypeResolvers implements PropertyTypeResolver
{
    /** @var PropertyTypeResolver[] */
    private array $inner;

    public function __construct(PropertyTypeResolver ...$inner)
    {
        $this->inner = $inner;
    }

    public static function default(): self
    {
        return new self(new TypedPropertyResolver(), new DocBlockPropertyResolver());
    }

    /**
     * @param ReflectionClass<object> $class
     */
    public function resolveType(ReflectionClass $class, ReflectionProperty $property): TypeInfo
    {
        $type = TypeInfo::ofMixed();

        foreach ($this->inner as $resolver) {
            $type = $resolver->resolveType($class, $property);

            if ($type->isStrict()) {
                break;
            }
        }

        return $type;
    }

    /**
     * @param ReflectionClass<object> $class
     */
    public function resolveMethodType(ReflectionClass $class, ReflectionMethod $method): TypeInfo
    {
        $type = TypeInfo::ofMixed();

        foreach ($this->inner as $resolver) {
            $type = $resolver->resolveMethodType($class, $method);

            if ($type->isStrict()) {
                break;
            }
        }

        return $type;
    }
}
