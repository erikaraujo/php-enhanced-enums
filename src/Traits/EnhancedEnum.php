<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Traits;

use ErikAraujo\PhpEnhancedEnums\Attributes\Label;
use ReflectionEnum;
use ReflectionClassConstant;

trait EnhancedEnum
{
    /**
     * @return array<int,string>
     */
    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }

    /**
     * @return array<int,string|int>
     */
    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }

    /**
     * @return array<int,string>
     */
    public static function labels(): array
    {
        return array_column(static::asSelectArray(), 'name');
    }

    /**
     * @return array<int,array{name:string,value:string|int}>
     */
    public static function asSelectArray(): array
    {
        $values = array_map(function (self $enum) {
            return [
                'name' => $enum->getLabel(),
                'value' => $enum->value,
            ];
        }, self::cases());

        return $values;
    }

    public function getLabel(): string
    {
        $ref = new ReflectionClassConstant(self::class, $this->name);
        $classAttributes = $ref->getAttributes(Label::class);

        if (count($classAttributes) === 0) {
            $parts = explode(' ', (string) $this->value);

            $parts = count($parts) > 1
                ? array_map(fn (string $value) => mb_convert_case($value, MB_CASE_TITLE, 'UTF-8'), $parts)
                : array_map(
                    fn (string $value) => mb_convert_case($value, MB_CASE_TITLE, 'UTF-8'),
                    preg_split('/(?=\p{Lu})/u', implode('_', $parts), -1, PREG_SPLIT_NO_EMPTY) ?: [],
                );

            $collapsed = str_replace(['-', '_', ' '], '_', implode('_', $parts));

            return implode(' ', array_filter(explode('_', $collapsed)));
        }

        return $classAttributes[0]->newInstance()->label;
    }

    public static function tryFromCanonicalizing(string|int $value): ?static
    {
        $isIntEnum = self::isIntEnum();

        /**
         * If enum is of type INT, value must be numeric for it to be parseable
         */
        if ($isIntEnum && ! (is_int($value) || is_numeric($value))) {
            return null;
        }

        if ($isIntEnum) {
            return self::tryFrom(intval($value));
        }

        if (is_string($value)) {
            foreach (static::cases() as $case) {
                if (strcasecmp((string) $case->value, $value) === 0) {
                    return $case;
                }
            }
        }

        return null;
    }

    public static function isIntEnum(): bool
    {
        return (new ReflectionEnum(self::class))->getBackingType()?->getName() === 'int';
    }
}
