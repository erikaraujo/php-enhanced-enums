<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Traits;

use ErikAraujo\PhpEnhancedEnums\Exceptions\NonBackedEnumsHaveNoValuesException;
use OutOfRangeException;

trait HasHelperMethods
{
    use HasTypeChecks;

    /**
     * @return array<int,string>
     */
    public static function getNames(): array
    {
        return array_column(static::cases(), 'name');
    }

    /**
     * @return array<int,string|int>
     */
    public static function getValues(): array
    {
        if (! self::isBackedEnum()) {
            throw new NonBackedEnumsHaveNoValuesException();
        }

        return array_column(static::cases(), 'value');
    }

    public function toString(): string
    {
        if (! static::isBackedEnum()) {
            throw new NonBackedEnumsHaveNoValuesException();
        }

        return (string) $this->value;
    }

    public static function getRandom(): static
    {
        $cases = static::cases();
        return $cases[array_rand($cases)];
    }

    public static function getCaseByPosition(int $position): static
    {
        if ($case = static::tryGetCaseByPosition($position)) {
            return $case;
        }

        throw new OutOfRangeException("No enum case found at position {$position}");
    }

    public static function tryGetCaseByPosition(int $position): ?static
    {
        return static::cases()[$position] ?? null;
    }

    public static function first(): static
    {
        return static::cases()[0];
    }

    public static function last(): static
    {
        $cases = static::cases();

        return end($cases);
    }
}
