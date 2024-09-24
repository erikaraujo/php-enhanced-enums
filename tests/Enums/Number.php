<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Tests\Enums;

use ErikAraujo\PhpEnhancedEnums\Attributes\Description;
use ErikAraujo\PhpEnhancedEnums\Attributes\Label;
use ErikAraujo\PhpEnhancedEnums\Traits\EnhancedEnum;
use ErikAraujo\PhpEnhancedEnums\Traits\HasDescription;
use ErikAraujo\PhpEnhancedEnums\Traits\HasLabel;
use ErikAraujo\PhpEnhancedEnums\Traits\IsSelectArray;

enum Number: int
{
    use EnhancedEnum;
    use HasLabel;
    use HasDescription;
    use IsSelectArray;

    #[Label('Number one')]
    case One = 1;

    case Two = 2;

    #[Description('This is the number three')]
    case Three = 3;
}
