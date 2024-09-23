<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Traits;

trait IsSelectArray
{
    use HasLabel;

    /**
     * @return array<int,array{name:string,value:string|int}>
     */
    public static function asSelectArray(): array
    {
        $values = array_map(function (self $enum) {
            return [
                'name' => $enum->getLabel() ?? $enum->value,
                'value' => $enum->value,
            ];
        }, self::cases());

        return $values;
    }
}
