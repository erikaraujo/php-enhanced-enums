<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Tests\Unit;

use ErikAraujo\PhpEnhancedEnums\Tests\Enums\NonBackedNumber;
use PHPUnit\Framework\TestCase;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\Suit;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\Number;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\SuitWithoutAutoLabelGeneration;

class HasLabelTest extends TestCase
{
    public function test_has_label_enum_returns_its_label(): void
    {
        $this->assertEquals('Hearts Suit', Suit::Hearts->getLabel());
        $this->assertEquals('Diamonds Suit', Suit::Diamonds->getLabel());
        $this->assertEquals('Clubs Suit', Suit::Clubs->getLabel());
        $this->assertEquals('Spades', Suit::Spades->getLabel());

        $this->assertEquals('Hearts Suit', SuitWithoutAutoLabelGeneration::Hearts->getLabel());
        $this->assertEquals('Diamonds Suit', SuitWithoutAutoLabelGeneration::Diamonds->getLabel());
        $this->assertEquals('Clubs Suit', SuitWithoutAutoLabelGeneration::Clubs->getLabel());
        $this->assertNull(SuitWithoutAutoLabelGeneration::Spades->getLabel());

        $this->assertEquals('Number one', Number::One->getLabel());
        $this->assertEquals('Two', Number::Two->getLabel());

        $this->assertEquals('Zero', NonBackedNumber::Zero->getLabel());
        $this->assertEquals('One', NonBackedNumber::One->getLabel());
        $this->assertEquals('Number two', NonBackedNumber::Two->getLabel());
    }

    public function test_has_label_enum_returns_an_array_of_its_labels(): void
    {
        $this->assertEquals([
            'Hearts Suit',
            'Diamonds Suit',
            'Clubs Suit',
            'Spades',
        ], Suit::getLabels());

        $this->assertEquals([
            'Hearts Suit',
            'Diamonds Suit',
            'Clubs Suit',
            null,
        ], SuitWithoutAutoLabelGeneration::getLabels());

        $this->assertEquals([
            'Number one',
            'Two',
            'Three',
        ], Number::getLabels());

        $this->assertEquals([
            'Zero',
            'One',
            'Number two',
        ], NonBackedNumber::getLabels());
    }

    public function test_has_label_enum_attempts_to_get_parsed_by_its_label(): void
    {
        $this->assertEquals(Suit::Hearts, Suit::tryFromLabel('Hearts Suit'));
        $this->assertEquals(Suit::Diamonds, Suit::tryFromLabel('Diamonds Suit'));
        $this->assertEquals(Suit::Clubs, Suit::tryFromLabel('Clubs Suit'));
        $this->assertEquals(Suit::Spades, Suit::tryFromLabel('Spades'));

        $this->assertNull(Suit::tryFromLabel('Hearts'));
        $this->assertNull(Suit::tryFromLabel('Hearts', ignoreCase: true));
        $this->assertNull(Suit::tryFromLabel('HeartS SUit'));
        $this->assertEquals(Suit::Hearts, Suit::tryFromLabel('HeartS SUit', ignoreCase: true));

        $this->assertEquals(Number::One, Number::tryFromLabel('Number one'));
        $this->assertEquals(Number::Two, Number::tryFromLabel('Two'));
        $this->assertEquals(Number::Three, Number::tryFromLabel('Three'));

        $this->assertNull(Number::tryFromLabel('NumberOne'));
        $this->assertNull(Number::tryFromLabel('NumberOne', ignoreCase: true));
        $this->assertNull(Number::tryFromLabel('Number One'));
        $this->assertEquals(Number::One, Number::tryFromLabel('Number One', ignoreCase: true));

        $this->assertEquals(NonBackedNumber::Zero, NonBackedNumber::tryFromLabel('Zero'));
        $this->assertEquals(NonBackedNumber::One, NonBackedNumber::tryFromLabel('One'));
        $this->assertEquals(NonBackedNumber::Two, NonBackedNumber::tryFromLabel('Number two'));

        $this->assertNull(NonBackedNumber::tryFromLabel('number zero'));
        $this->assertNull(NonBackedNumber::tryFromLabel('number zero', ignoreCase: true));
        $this->assertNull(NonBackedNumber::tryFromLabel('zero'));
        $this->assertEquals(NonBackedNumber::Zero, NonBackedNumber::tryFromLabel('zero', ignoreCase: true));
    }
}
