<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Tests\Unit;

use ErikAraujo\PhpEnhancedEnums\Exceptions\CannotIncludeDescriptionWithoutHasDescriptionTraitException;
use ErikAraujo\PhpEnhancedEnums\Exceptions\NonBackedEnumsHaveNoValuesException;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\NonBackedNumber;
use PHPUnit\Framework\TestCase;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\Suit;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\Number;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\SuitWithoutAutoLabelGeneration;

class IsSelectArrayTest extends TestCase
{
    public function test_is_select_array_enum_returns_itself_as_select_array(): void
    {
        $this->assertEquals([
            [
                'name' => 'Hearts Suit',
                'value' => 'Hearts Suit',
            ],
            [
                'name' => 'Diamonds Suit',
                'value' => 'diamonds',
            ],
            [
                'name' => 'Clubs Suit',
                'value' => 'clubs',
            ],
            [
                'name' => 'Spades',
                'value' => 'spades',
            ],
        ], Suit::asSelectArray());

        $this->assertEquals([
            [
                'name' => 'Number one',
                'value' => 1,
            ],
            [
                'name' => 'Two',
                'value' => 2,
            ],
            [
                'name' => 'Three',
                'value' => 3,
            ],
        ], Number::asSelectArray());

        $this->expectException(NonBackedEnumsHaveNoValuesException::class);
        NonBackedNumber::asSelectArray();
    }

    public function test_is_select_array_enum_returns_itself_as_select_array_with_descriptions(): void
    {
        $this->assertEquals([
            [
                'name' => 'Hearts Suit',
                'value' => 'Hearts Suit',
                'description' => null,
            ],
            [
                'name' => 'Diamonds Suit',
                'value' => 'diamonds',
                'description' => 'The diamonds suit',
            ],
            [
                'name' => 'Clubs Suit',
                'value' => 'clubs',
                'description' => null,
            ],
            [
                'name' => 'Spades',
                'value' => 'spades',
                'description' => 'The spades suit',
            ],
        ], Suit::asSelectArray(includeDescription: true));

        $this->assertEquals([
            [
                'name' => 'Number one',
                'value' => 1,
                'description' => null,
            ],
            [
                'name' => 'Two',
                'value' => 2,
                'description' => null,
            ],
            [
                'name' => 'Three',
                'value' => 3,
                'description' => 'This is the number three',
            ],
        ], Number::asSelectArray(includeDescription: true));

        $this->expectException(NonBackedEnumsHaveNoValuesException::class);
        NonBackedNumber::asSelectArray(includeDescription: true);
    }

    public function test_is_select_array_enum_throws_exception_when_attempting_to_return_description_without_get_description(): void
    {
        $this->expectException(CannotIncludeDescriptionWithoutHasDescriptionTraitException::class);
        SuitWithoutAutoLabelGeneration::asSelectArray(includeDescription: true);
    }
}
