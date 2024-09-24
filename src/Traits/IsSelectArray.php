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
     *          ? array<int,array{name:string,value:string|int,description:?string}>
     *          : array<int,array{name:string,value:string|int}>
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
                'name' => $enum->getLabel() ?? (string) $enum->value,
                'value' => $enum->value,
                ...$includeDescription
                    ? ['description' => $enum->getDescription()]
                    : [],
            ];
        }, self::cases());
    }
}
