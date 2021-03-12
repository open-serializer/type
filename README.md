# PHP Type Tools

```php
class Foo 
{
    /** @return array<int> */
    public function test(): array
    {
        return [];
    }
}

$typeResolver = new PropertyTypeResolvers(
    new TypedPropertyResolver(),
    new DocBlockPropertyResolver(),
);

$classInfo = new ReflectionClass(Foo::class);
$methodInfo = $classInfo->getMethod('test');
$typeInfo = $typeResolver->resolveMethodType($classInfo, $methodInfo);
```
