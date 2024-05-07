<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Tests\Enums;

use ErikAraujo\PhpEnhancedEnums\Attributes\Label;
use ErikAraujo\PhpEnhancedEnums\Traits\EnhancedEnum;

enum Suit: string
{
    use EnhancedEnum;

    #[Label('Hearts Suit')]
    case Hearts = 'hearts';

    #[Label('Diamonds Suit')]
    case Diamonds = 'diamonds';

    #[Label('Clubs Suit')]
    case Clubs = 'clubs';

    case Spades = 'spades';
}
