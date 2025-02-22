<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Traits;

use ErikAraujo\PhpEnhancedEnums\Exceptions\CannotParseNonBackedEnumsException;

trait IsParsable
{
    use HasTypeChecks;

    public static function parse(int|string $value): static
    {
        if (! static::isBackedEnum()) {
            throw new CannotParseNonBackedEnumsException();
        }

        return static::from($value);
    }

    public static function tryParse(int|string $value, bool $ignoreCase = false): ?static
    {
        if (! static::isBackedEnum()) {
            throw new CannotParseNonBackedEnumsException();
        }

        if ($ignoreCase) {
            return static::tryFromIgnoringCase($value);
        }

        return static::tryFrom($value);
    }

    public static function tryFromIgnoringCase(string|int $value): ?static
    {
        if (! static::isBackedEnum()) {
            throw new CannotParseNonBackedEnumsException();
        }

        $isIntEnum = static::isIntEnum();

        /**
         * If enum is of type INT, value must be numeric for it to be parseable
         */
        if ($isIntEnum && ! (is_int($value) || is_numeric($value))) {
            return null;
        }

        if ($isIntEnum) {
            return static::tryFrom(intval($value));
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

    public static function tryParseIgnoringCase(string|int $value): ?static
    {
        return static::tryFromIgnoringCase($value);
    }
}
