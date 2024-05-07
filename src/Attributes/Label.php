<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_CLASS)]
class Label
{
    public function __construct(
        public string $label,
    ) {
    }
}
