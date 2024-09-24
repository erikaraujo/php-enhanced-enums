<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Tests\Enums;

use ErikAraujo\PhpEnhancedEnums\Attributes\Label;
use ErikAraujo\PhpEnhancedEnums\Traits\HasLabel;
use ErikAraujo\PhpEnhancedEnums\Traits\IsSelectArray;

enum SuitWithoutAutoLabelGeneration: string
{
    use HasLabel;
    use IsSelectArray;

    #[Label('Hearts Suit')]
    case Hearts = 'hearts';

    #[Label('Diamonds Suit')]
    case Diamonds = 'diamonds';

    #[Label('Clubs Suit')]
    case Clubs = 'clubs';

    case Spades = 'spades';

    protected function shouldAutoGenerateLabelFromValue(): bool
    {
        return false;
    }
}
