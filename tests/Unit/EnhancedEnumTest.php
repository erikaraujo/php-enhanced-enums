<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\Suit;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\Number;
use ErikAraujo\PhpEnhancedEnums\Traits\EnhancedEnum;

#[CoversClass(EnhancedEnum::class)]
class EnhancedEnumTest extends TestCase
{
    public function test_enum_returns_an_array_of_its_names(): void
    {
        $this->assertEqualsCanonicalizing([
            'Hearts',
            'Diamonds',
            'Clubs',
            'Spades',
        ], Suit::getNames());
    }

    public function test_enum_returns_an_array_of_its_values(): void
    {
        $this->assertEqualsCanonicalizing([
            'hearts',
            'diamonds',
            'clubs',
            'spades',
        ], Suit::getValues());
    }

    public function test_enum_returns_an_array_of_its_labels(): void
    {
        $this->assertEqualsCanonicalizing([
            'Hearts Suit',
            'Diamonds Suit',
            'Clubs Suit',
            'Spades',
        ], Suit::getLabels());
    }

    public function test_enum_returns_itself_as_select_array(): void
    {
        $this->assertEqualsCanonicalizing([
            [
                'name' => 'Hearts Suit',
                'value' => 'hearts',
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
    }

    public function test_enhanced_enum_returns_itself_canonicalizing_string(): void
    {
        $this->assertEquals(Suit::Spades, Suit::tryFromIgnoringCase('spades'));
        $this->assertEquals(Suit::Spades, Suit::tryFromIgnoringCase('sPaDeS'));
        $this->assertNull(Suit::tryFromIgnoringCase('non_existing_suit'));
    }

    public function test_enhanced_enum_returns_itself_canonicalizing_int(): void
    {
        $this->assertEquals(Number::One, Number::tryFromIgnoringCase(1));
        $this->assertEquals(Number::Two, Number::tryFromIgnoringCase('2'));

        $this->assertNull(Number::tryFromIgnoringCase('three'));
    }

    public function test_enhanced_enum_instance_returns_its_label(): void
    {
        $this->assertEquals('Hearts Suit', Suit::Hearts->getLabel());
        $this->assertEquals('Spades', Suit::Spades->getLabel());
    }
}
