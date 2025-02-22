<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Traits;

use BackedEnum;
use ErikAraujo\PhpEnhancedEnums\Exceptions\CannotIncludeDescriptionWithoutHasDescriptionTraitException;
use ErikAraujo\PhpEnhancedEnums\Exceptions\NonBackedEnumsHaveNoValuesException;
use ReflectionEnum;

trait IsSelectArray
{
    use HasLabel;

    /**
     * @return (
     *      $includeDescription is true
     *          ? array<int,array<string,string|int|null>>
     *          : array<int,array<string,string|int>>
     * )
     */
    public static function asSelectArray(bool $includeDescription = false): array
    {
        if (! in_array(BackedEnum::class, (new ReflectionEnum(static::class))->getInterfaceNames())) {
            throw new NonBackedEnumsHaveNoValuesException();
        }

        if ($includeDescription && ! method_exists(static::class, 'getDescription')) {
            throw new CannotIncludeDescriptionWithoutHasDescriptionTraitException();
        }

        return array_map(function (self $enum) use ($includeDescription) {
            return [
                static::getSelectArrayNameKey() => $enum->getLabel() ?? (string) $enum->value,
                static::getSelectArrayValueKey() => $enum->value,
                ...$includeDescription
                    ? [static::getSelectArrayDescriptionKey() => $enum->getDescription()]
                    : [],
            ];
        }, static::cases());
    }

    protected static function getSelectArrayNameKey(): string
    {
        return 'name';
    }

    protected static function getSelectArrayValueKey(): string
    {
        return 'value';
    }

    protected static function getSelectArrayDescriptionKey(): string
    {
        return 'description';
    }
}
