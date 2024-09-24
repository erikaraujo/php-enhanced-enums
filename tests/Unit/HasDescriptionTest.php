<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Tests\Unit;

use ErikAraujo\PhpEnhancedEnums\Tests\Enums\NonBackedNumber;
use PHPUnit\Framework\TestCase;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\Suit;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\Number;

class HasDescriptionTest extends TestCase
{
    public function test_has_description_enum_returns_its_description(): void
    {
        $this->assertNull(Suit::Hearts->getDescription());
        $this->assertEquals('The diamonds suit', Suit::Diamonds->getDescription());
        $this->assertNull(Suit::Clubs->getDescription());
        $this->assertEquals('The spades suit', Suit::Spades->getDescription());

        $this->assertNull(Number::One->getDescription());
        $this->assertNull(Number::Two->getDescription());
        $this->assertEquals('This is the number three', Number::Three->getDescription());

        $this->assertNull(NonBackedNumber::Zero->getDescription());
        $this->assertEquals('This is the number one', NonBackedNumber::One->getDescription());
        $this->assertNull(NonBackedNumber::Two->getDescription());
    }

    public function test_has_description_enum_returns_an_array_of_its_descriptions(): void
    {
        $this->assertEquals([
            null,
            'The diamonds suit',
            null,
            'The spades suit',
        ], Suit::getDescriptions());

        $this->assertEquals([
            null,
            null,
            'This is the number three',
        ], Number::getDescriptions());

        $this->assertEquals([
            null,
            'This is the number one',
            null,
        ], NonBackedNumber::getDescriptions());
    }

    public function test_has_description_enum_attempts_to_get_parsed_by_its_description(): void
    {
        $this->assertEquals(Suit::Diamonds, Suit::tryFromDescription('The diamonds suit'));
        $this->assertEquals(Suit::Spades, Suit::tryFromDescription('The spades suit'));

        $this->assertNull(Suit::tryFromDescription('The hearts suit'));
        $this->assertNull(Suit::tryFromDescription('The hearts suit', ignoreCase: true));
        $this->assertNull(Suit::tryFromDescription('The Diamonds Suit'));
        $this->assertEquals(Suit::Diamonds, Suit::tryFromDescription('The Diamonds Suit', ignoreCase: true));

        $this->assertEquals(Number::Three, Number::tryFromDescription('This is the number three'));

        $this->assertNull(Number::tryFromDescription('This is the number one'));
        $this->assertNull(Number::tryFromDescription('This is the number one', ignoreCase: true));
        $this->assertNull(Number::tryFromDescription('This is the Number Three'));
        $this->assertEquals(Number::Three, Number::tryFromDescription('This is the Number Three', ignoreCase: true));

        $this->assertEquals(NonBackedNumber::One, NonBackedNumber::tryFromDescription('This is the number one'));

        $this->assertNull(NonBackedNumber::tryFromDescription('This is the number two'));
        $this->assertNull(NonBackedNumber::tryFromDescription('This is the number two', ignoreCase: true));
        $this->assertNull(NonBackedNumber::tryFromDescription('This is the Number One'));
        $this->assertEquals(NonBackedNumber::One, NonBackedNumber::tryFromDescription('This is the Number One', ignoreCase: true));
    }
}
