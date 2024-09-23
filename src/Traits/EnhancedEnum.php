<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Traits;

use OutOfRangeException;
use ReflectionEnum;
use ReflectionNamedType;

trait EnhancedEnum
{
    public static function parse(int|string $value): static
    {
        return static::from($value);
    }

    public static function tryParse(int|string $value, bool $ignoreCase = false): ?static
    {
        if ($ignoreCase) {
            return static::tryFromIgnoringCase($value);
        }

        return static::tryParse($value);
    }

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
        return array_column(static::cases(), 'value');
    }

    public static function isDefined(int|string $value, bool $ignoreCase = false): bool
    {
        if ($ignoreCase) {
            return static::tryFromIgnoringCase($value) !== null;
        }

        if (self::tryFrom($value)) {
            return true;
        }

        return false;
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function is(self|int|string $value, bool $ignoreCase = false): bool
    {
        if (is_int($value)) {
            return (int) $this->value === $value;
        }

        if (is_string($value)) {
            if ($ignoreCase) {
                return strcasecmp((string) $this->value, $value) === 0;
            }

            return (string) $this->value === $value;
        }

        return $this === $value;
    }

    public static function tryFromIgnoringCase(string|int $value): ?static
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

    public static function tryParseIgnoringCase(string|int $value): ?static
    {
        return self::tryFromIgnoringCase($value);
    }

    public static function getBackingType(): ?ReflectionNamedType
    {
        return (new ReflectionEnum(self::class))->getBackingType();
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

    public static function getRandom(): self
    {
        $cases = static::cases();
        return $cases[array_rand($cases)];
    }

    public static function getCaseByPosition(int $position): self
    {
        if ($case = self::tryGetCaseByPosition($position)) {
            return $case;
        }

        throw new OutOfRangeException("No enum case found at position {$position}");
    }

    public static function tryGetCaseByPosition(int $position): ?self
    {
        return self::cases()[$position] ?? null;
    }

    public static function first(): self
    {
        return self::cases()[0];
    }

    public static function last(): self
    {
        $cases = self::cases();
        return end($cases);
    }
}
