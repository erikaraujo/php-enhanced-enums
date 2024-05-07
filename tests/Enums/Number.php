<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Tests\Enums;

use ErikAraujo\PhpEnhancedEnums\Traits\EnhancedEnum;

enum Number: int
{
    use EnhancedEnum;

    case One = 1;

    case Two = 2;

    case Three = 3;
}
