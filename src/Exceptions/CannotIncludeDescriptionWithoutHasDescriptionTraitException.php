<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Exceptions;

use Exception;

class CannotIncludeDescriptionWithoutHasDescriptionTraitException extends Exception
{
    public function __construct()
    {
        parent::__construct('Expects description, but `HasDescription` trait isn\'t used.');
    }
}
