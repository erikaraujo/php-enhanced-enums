<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Exceptions;

use Exception;

class NonBackedEnumsHaveNoValuesException extends Exception
{
    public function __construct()
    {
        parent::__construct('Non-backed enums have no values');
    }
}
