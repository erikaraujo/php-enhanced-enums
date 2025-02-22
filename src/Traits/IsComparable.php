<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Traits;

use ErikAraujo\PhpEnhancedEnums\Exceptions\NonBackedEnumsHaveNoValuesException;

trait IsComparable
{
    use HasTypeChecks;
    use IsParsable;

    public function is(self|int|string $value, bool $ignoreCase = false): bool
    {
        if (is_int($value)) {
            if (! static::isBackedEnum()) {
                throw new NonBackedEnumsHaveNoValuesException();
            }

            return (int) $this->value === $value;
        }

        if (is_string($value)) {
            if (! static::isBackedEnum()) {
                throw new NonBackedEnumsHaveNoValuesException();
            }

            if ($ignoreCase) {
                return strcasecmp((string) $this->value, $value) === 0;
            }

            return (string) $this->value === $value;
        }

        return $this === $value;
    }

    public function isNot(self|int|string $value, bool $ignoreCase = false): bool
    {
        return ! $this->is($value, $ignoreCase);
    }

    public static function isDefined(int|string $value, bool $ignoreCase = false): bool
    {
        if (! self::isBackedEnum()) {
            throw new NonBackedEnumsHaveNoValuesException();
        }

        if ($ignoreCase) {
            return static::tryFromIgnoringCase($value) !== null;
        }

        if (self::tryFrom($value)) {
            return true;
        }

        return false;
    }
}
