<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Traits;

use ErikAraujo\PhpEnhancedEnums\Attributes\Description;
use ReflectionClassConstant;

trait HasDescription
{
    public function getDescription(): ?string
    {
        $ref = new ReflectionClassConstant(self::class, $this->name);

        $descriptionClassAttributes = $ref->getAttributes(Description::class);
        if (count($descriptionClassAttributes) > 0) {
            return $descriptionClassAttributes[0]->newInstance()->description;
        }

        return null;
    }

    /**
     * @return array<int,?string>
     */
    public static function getDescriptions(): array
    {
        return array_map(
            fn (self $enum): ?string => $enum->getDescription(),
            self::cases()
        );
    }

    public static function tryFromDescription(string $description, bool $ignoreCase = false): ?self
    {
        if ($ignoreCase) {
            return static::tryFromDescriptionIgnoringCase($description);
        }

        foreach (self::cases() as $case) {
            if ($case->getDescription() === $description) {
                return $case;
            }
        }
        return null;
    }

    public static function tryFromDescriptionIgnoringCase(string $description): ?self
    {
        foreach (static::cases() as $case) {
            if (strcasecmp((string) $case->getDescription(), $description) === 0) {
                return $case;
            }
        }

        return null;
    }
}
