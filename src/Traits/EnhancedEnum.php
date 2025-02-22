<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Traits;

trait EnhancedEnum
{
    use HasTypeChecks;
    use IsParsable;
    use HasHelperMethods;
    use IsComparable;
    use HasDescription;
    use HasLabel;
    use IsSelectArray;
}
