<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Exceptions;

use Exception;

class CannotParseNonBackedEnumsException extends Exception
{
    public function __construct()
    {
        parent::__construct('Cannot parse non-backed enums');
    }
}
