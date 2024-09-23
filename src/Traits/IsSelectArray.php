<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Traits;

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
        if ($includeDescription && ! method_exists(static::class, 'getDescription')) {
            // TODO: custom exception
            throw new \Exception('Expects description, but `HasDescription` trait isn\'t used.');
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
