<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Tests\Enums;

use ErikAraujo\PhpEnhancedEnums\Attributes\Description;
use ErikAraujo\PhpEnhancedEnums\Attributes\Label;
use ErikAraujo\PhpEnhancedEnums\Traits\HasLabel;
use ErikAraujo\PhpEnhancedEnums\Traits\EnhancedEnum;
use ErikAraujo\PhpEnhancedEnums\Traits\IsSelectArray;
use ErikAraujo\PhpEnhancedEnums\Traits\HasDescription;

enum NonBackedNumber
{
    use EnhancedEnum;
    use HasLabel;
    use HasDescription;
    use IsSelectArray;

    case Zero;

    #[Description('This is the number one')]
    case One;

    #[Label('Number two')]
    case Two;
}
