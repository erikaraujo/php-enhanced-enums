<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Traits;

use BackedEnum;
use ReflectionEnum;
use ReflectionNamedType;

trait HasTypeChecks
{
    public static function isBackedEnum(): bool
    {
        return is_subclass_of(static::class, BackedEnum::class);
    }

    public static function getBackingType(): ?ReflectionNamedType
    {
        return (new ReflectionEnum(static::class))->getBackingType();
    }

    public static function getUnderlyingType(): ?ReflectionNamedType
    {
        return static::getBackingType();
    }

    public static function isIntEnum(): bool
    {
        return static::getBackingType()?->getName() === 'int';
    }

    public static function isStringEnum(): bool
    {
        return static::getBackingType()?->getName() === 'string';
    }
}
