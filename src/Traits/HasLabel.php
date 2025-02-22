<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Traits;

use ErikAraujo\PhpEnhancedEnums\Attributes\Label;
use ReflectionClassConstant;
use ReflectionEnum;

trait HasLabel
{
    public function getLabel(): ?string
    {
        $ref = new ReflectionClassConstant(static::class, $this->name);
        $labelClassAttributes = $ref->getAttributes(Label::class);

        if (count($labelClassAttributes) > 0) {
            return $labelClassAttributes[0]->newInstance()->label;
        }

        if ($this->shouldAutoGenerateLabelFromValue()) {
            return $this->generateLabelFromValue();
        }

        return null;
    }

    /**
     * @return array<int,?string>
     */
    public static function getLabels(): array
    {
        return array_map(
            fn (self $enum): ?string => $enum->getLabel(),
            static::cases()
        );
    }

    public static function tryFromLabel(string $label, bool $ignoreCase = false): ?static
    {
        if ($ignoreCase) {
            return static::tryFromLabelIgnoringCase($label);
        }

        foreach (static::cases() as $case) {
            if ($case->getLabel() === $label) {
                return $case;
            }
        }
        return null;
    }

    public static function tryFromLabelIgnoringCase(string $label): ?static
    {
        foreach (static::cases() as $case) {
            if (strcasecmp((string) $case->getLabel(), $label) === 0) {
                return $case;
            }
        }

        return null;
    }

    protected function shouldAutoGenerateLabelFromValue(): bool
    {
        return true;
    }

    private function generateLabelFromValue(): string
    {
        $parts = explode(' ', $this->getValueToBeUsedForLabelAutomaticGeneration());

        $parts = count($parts) > 1
            ? array_map(
                fn (string $value): string => mb_convert_case($value, MB_CASE_TITLE, 'UTF-8'),
                $parts
            )
            : array_map(
                fn (string $value): string => mb_convert_case($value, MB_CASE_TITLE, 'UTF-8'),
                preg_split('/(?=\p{Lu})/u', implode('_', $parts), -1, PREG_SPLIT_NO_EMPTY) ?: []
            );

        $collapsed = str_replace(['-', '_', ' '], '_', implode('_', $parts));

        return implode(' ', array_filter(explode('_', $collapsed)));
    }

    private function getValueToBeUsedForLabelAutomaticGeneration(): string
    {
        $backingType = (new ReflectionEnum(static::class))->getBackingType();

        return (is_null($backingType) || $backingType->getName() === 'int')
            ? $this->name
            : $this->value;
    }
}
