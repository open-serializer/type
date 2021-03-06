<?php declare(strict_types=1);

namespace OpenSerializer\Type;

use function class_exists;
use function in_array;

final class TypeInfo
{
    public const SCALAR_TYPES = ['int', 'float', 'string', 'bool'];
    private string $type;
    private bool $isNullable;
    private ?TypeInfo $innerType;

    private function __construct(string $type, bool $isNullable, ?TypeInfo $innerType = null)
    {
        $this->type = $type;
        $this->isNullable = $isNullable;
        $this->innerType = $innerType;
    }

    public static function ofMixed(): self
    {
        return new self('mixed', true, null);
    }

    public static function ofBuiltIn(string $type, bool $isNullable): self
    {
        return new self($type, $isNullable);
    }

    public static function ofObject(string $type, bool $isNullable): self
    {
        return new self($type, $isNullable);
    }

    public static function ofArray(bool $isNullable, ?TypeInfo $innerType): self
    {
        return new self('array', $isNullable, $innerType);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function innerType(): TypeInfo
    {
        return $this->innerType ?? TypeInfo::ofMixed();
    }

    public function isArray(): bool
    {
        return $this->hasTypeIn('array');
    }

    public function isMixed(): bool
    {
        return $this->hasTypeIn('mixed');;
    }

    public function isObject(): bool
    {
        return class_exists($this->type);
    }

    public function isString(): bool
    {
        return $this->hasTypeIn('string');
    }

    public function isInteger(): bool
    {
        return $this->hasTypeIn('integer', 'int');
    }

    public function isFloat(): bool
    {
        return $this->hasTypeIn('float');
    }

    public function isBoolean(): bool
    {
        return $this->hasTypeIn('bool', 'boolean');
    }

    public function isNullable(): bool
    {
        return $this->isNullable;
    }

    public function isScalar(): bool
    {
        return $this->hasTypeIn(...self::SCALAR_TYPES);
    }

    public function isStrict(): bool
    {
        return $this->isScalar()
            || $this->isObject()
            || ($this->isArray() && $this->innerType !== null);
    }

    private function hasTypeIn(string ...$types): bool
    {
        return in_array($this->type, $types, true);
    }
}
