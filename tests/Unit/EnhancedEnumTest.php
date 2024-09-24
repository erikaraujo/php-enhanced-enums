<?php

declare(strict_types=1);

namespace ErikAraujo\PhpEnhancedEnums\Tests\Unit;

use ErikAraujo\PhpEnhancedEnums\Exceptions\CannotParseNonBackedEnumsException;
use ErikAraujo\PhpEnhancedEnums\Exceptions\NonBackedEnumsHaveNoValuesException;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\NonBackedNumber;
use PHPUnit\Framework\TestCase;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\Suit;
use ErikAraujo\PhpEnhancedEnums\Tests\Enums\Number;
use OutOfRangeException;
use ReflectionNamedType;

class EnhancedEnumTest extends TestCase
{
    public function test_it_parses_enhanced_enum_values(): void
    {
        $this->assertEquals(Suit::Hearts, Suit::parse('Hearts Suit'));
        $this->assertEquals(Suit::Diamonds, Suit::parse('diamonds'));
        $this->assertEquals(Suit::Clubs, Suit::parse('clubs'));
        $this->assertEquals(Suit::Spades, Suit::parse('spades'));

        $this->assertEquals(Number::One, Number::parse(1));
        $this->assertEquals(Number::Two, Number::parse(2));
        $this->assertEquals(Number::Three, Number::parse(3));
    }

    public function test_fails_to_parse_non_backed_enhanced_enums_even_with_correct_values(): void
    {
        $this->expectException(CannotParseNonBackedEnumsException::class);
        NonBackedNumber::parse(1);
    }

    public function test_it_parses_enhanced_enum_values_and_returns_null_for_invalid_values(): void
    {
        $this->assertEquals(Suit::Hearts, Suit::tryParse('Hearts Suit'));
        $this->assertEquals(Suit::Diamonds, Suit::tryParse('diamonds'));
        $this->assertEquals(Suit::Clubs, Suit::tryParse('clubs'));
        $this->assertEquals(Suit::Spades, Suit::tryParse('spades'));

        $this->assertEquals(Number::One, Number::tryParse(1));
        $this->assertEquals(Number::Two, Number::tryParse(2));
        $this->assertEquals(Number::Three, Number::tryParse(3));

        $this->assertNull(Suit::tryParse('invalid_suit'));
        $this->assertNull(Number::tryParse(4));
    }

    public function test_fails_to_try_parse_non_backed_enhanced_enums_even_with_correct_values(): void
    {
        $this->expectException(CannotParseNonBackedEnumsException::class);
        NonBackedNumber::tryParse(1);
    }

    public function test_enhanced_enum_parses_enum_values_ignoring_case(): void
    {
        $this->assertNull(Suit::tryParse('HeaRtS SuIt', ignoreCase: false));

        $this->assertEquals(Suit::Hearts, Suit::tryParse('HeaRtS SuIt', ignoreCase: true));
        $this->assertEquals(Suit::Hearts, Suit::tryParseIgnoringCase('HeaRtS SuIt'));
        $this->assertEquals(Suit::Hearts, Suit::tryFromIgnoringCase('HeaRtS SuIt'));

        $this->assertNull(Number::tryFromIgnoringCase('Nine'));
        $this->assertEquals(Number::One, Number::tryFromIgnoringCase('1'));

        $this->assertNull(Suit::tryParse('invalid_suit', ignoreCase: false));
        $this->assertNull(Suit::tryParse('invalid_suit', ignoreCase: true));

        $this->expectException(CannotParseNonBackedEnumsException::class);
        NonBackedNumber::tryFromIgnoringCase('1');
    }

    public function test_enhanced_enum_returns_an_array_of_its_names(): void
    {
        $this->assertEquals([
            'Hearts',
            'Diamonds',
            'Clubs',
            'Spades',
        ], Suit::getNames());

        $this->assertEquals([
            'One',
            'Two',
            'Three',
        ], Number::getNames());

        $this->assertEquals([
            'Zero',
            'One',
            'Two',
        ], NonBackedNumber::getNames());
    }

    public function test_enhanced_enum_returns_an_array_of_its_values(): void
    {
        $this->assertEquals([
            'Hearts Suit',
            'diamonds',
            'clubs',
            'spades',
        ], Suit::getValues());

        $this->assertEquals([
            1,
            2,
            3,
        ], Number::getValues());

        $this->expectException(NonBackedEnumsHaveNoValuesException::class);
        NonBackedNumber::getValues();
    }

    public function test_enhanced_enum_is_defined_method_checks_if_value_exists_in_the_enum(): void
    {
        $this->assertTrue(Suit::isDefined('Hearts Suit'));
        $this->assertTrue(Suit::isDefined('diamonds'));
        $this->assertTrue(Suit::isDefined('clubs'));
        $this->assertTrue(Suit::isDefined('spades'));

        $this->assertFalse(Suit::isDefined('hEaRtS sUiT', ignoreCase: false));
        $this->assertFalse(Suit::isDefined('dIaMoNdS', ignoreCase: false));
        $this->assertFalse(Suit::isDefined('cLuBs', ignoreCase: false));
        $this->assertFalse(Suit::isDefined('sPaDeS', ignoreCase: false));

        $this->assertTrue(Suit::isDefined('hEaRtS sUiT', ignoreCase: true));
        $this->assertTrue(Suit::isDefined('dIaMoNdS', ignoreCase: true));
        $this->assertTrue(Suit::isDefined('cLuBs', ignoreCase: true));
        $this->assertTrue(Suit::isDefined('sPaDeS', ignoreCase: true));

        $this->assertTrue(Number::isDefined(1));
        $this->assertTrue(Number::isDefined(2));
        $this->assertTrue(Number::isDefined(3));

        $this->assertFalse(Suit::isDefined('invalid_suit'));
        $this->assertFalse(Number::isDefined(4));

        $this->expectException(NonBackedEnumsHaveNoValuesException::class);
        NonBackedNumber::isDefined(0);
    }

    public function test_enhanced_enum_is_returned_as_string(): void
    {
        $this->assertEquals('Hearts Suit', Suit::Hearts->toString());
        $this->assertEquals('diamonds', Suit::Diamonds->toString());
        $this->assertEquals('clubs', Suit::Clubs->toString());
        $this->assertEquals('spades', Suit::Spades->toString());

        $this->assertEquals('1', Number::One->toString());
        $this->assertEquals('2', Number::Two->toString());
        $this->assertEquals('3', Number::Three->toString());

        $this->expectException(NonBackedEnumsHaveNoValuesException::class);
        NonBackedNumber::Zero->toString();
    }

    public function test_enhanced_enum_checks_if_is_the_same(): void
    {
        $this->assertTrue(Suit::Hearts->is('Hearts Suit'));
        $this->assertTrue(Suit::Hearts->is(Suit::Hearts));
        $this->assertTrue(Suit::Hearts->is('Hearts Suit', ignoreCase: true));
        $this->assertTrue(Suit::Hearts->is('HeaRts SuIt', ignoreCase: true));
        $this->assertFalse(Suit::Hearts->is('HeaRts SuIt', ignoreCase: false));

        $this->assertTrue(Number::One->is(1));
        $this->assertTrue(Number::One->is(Number::One));
        $this->assertFalse(Number::One->is(2));

        $this->assertTrue(NonBackedNumber::Zero->is(NonBackedNumber::Zero));
        $this->assertFalse(NonBackedNumber::Zero->is(NonBackedNumber::One));

        $this->expectException(NonBackedEnumsHaveNoValuesException::class);
        NonBackedNumber::Zero->is(0);
    }

    public function test_enhanced_enum_checks_if_is_the_same_throws_exception_for_string_value_non_backed_enum(): void
    {
        $this->expectException(NonBackedEnumsHaveNoValuesException::class);
        NonBackedNumber::Zero->is('zero');
    }

    public function test_enhanced_enums_have_backing_type_helpers(): void
    {
        $this->assertTrue(Suit::isStringEnum());
        $this->assertFalse(Suit::isIntEnum());

        $this->assertInstanceOf(ReflectionNamedType::class, Suit::getBackingType());
        $this->assertInstanceOf(ReflectionNamedType::class, Suit::getUnderlyingType());

        $this->assertFalse(Number::isStringEnum());
        $this->assertTrue(Number::isIntEnum());

        $this->assertInstanceOf(ReflectionNamedType::class, Number::getBackingType());
        $this->assertInstanceOf(ReflectionNamedType::class, Number::getUnderlyingType());

        $this->assertFalse(NonBackedNumber::isStringEnum());
        $this->assertFalse(NonBackedNumber::isIntEnum());

        $this->assertNull(NonBackedNumber::getBackingType());
        $this->assertNull(NonBackedNumber::getUnderlyingType());
    }

    public function test_enhanced_enum_get_case_from_its_position(): void
    {
        $this->assertEquals(Suit::Hearts, Suit::getCaseByPosition(0));
        $this->assertEquals(Suit::Diamonds, Suit::getCaseByPosition(1));
        $this->assertEquals(Suit::Clubs, Suit::getCaseByPosition(2));
        $this->assertEquals(Suit::Spades, Suit::getCaseByPosition(3));

        $this->assertEquals(Number::One, Number::getCaseByPosition(0));
        $this->assertEquals(Number::Two, Number::getCaseByPosition(1));
        $this->assertEquals(Number::Three, Number::getCaseByPosition(2));

        $this->assertEquals(NonBackedNumber::Zero, NonBackedNumber::getCaseByPosition(0));
        $this->assertEquals(NonBackedNumber::One, NonBackedNumber::getCaseByPosition(1));
        $this->assertEquals(NonBackedNumber::Two, NonBackedNumber::getCaseByPosition(2));

        $this->expectException(OutOfRangeException::class);
        Suit::getCaseByPosition(5);
    }

    public function test_enhanced_enum_try_to_get_case_from_its_position_and_returns_null_if_out_of_range(): void
    {
        $this->assertEquals(Suit::Hearts, Suit::tryGetCaseByPosition(0));
        $this->assertEquals(Suit::Diamonds, Suit::tryGetCaseByPosition(1));
        $this->assertEquals(Suit::Clubs, Suit::tryGetCaseByPosition(2));
        $this->assertEquals(Suit::Spades, Suit::tryGetCaseByPosition(3));
        $this->assertNull(Suit::tryGetCaseByPosition(4));

        $this->assertEquals(Number::One, Number::tryGetCaseByPosition(0));
        $this->assertEquals(Number::Two, Number::tryGetCaseByPosition(1));
        $this->assertEquals(Number::Three, Number::tryGetCaseByPosition(2));
        $this->assertNull(Number::tryGetCaseByPosition(3));

        $this->assertEquals(NonBackedNumber::Zero, NonBackedNumber::tryGetCaseByPosition(0));
        $this->assertEquals(NonBackedNumber::One, NonBackedNumber::tryGetCaseByPosition(1));
        $this->assertEquals(NonBackedNumber::Two, NonBackedNumber::tryGetCaseByPosition(2));
        $this->assertNull(NonBackedNumber::tryGetCaseByPosition(3));
    }

    public function test_returns_the_first_case_of_the_enhanced_enum(): void
    {
        $this->assertEquals(Suit::Hearts, Suit::first());
        $this->assertEquals(Number::One, Number::first());
        $this->assertEquals(NonBackedNumber::Zero, NonBackedNumber::first());
    }

    public function test_returns_the_last_case_of_the_enhanced_enum(): void
    {
        $this->assertEquals(Suit::Spades, Suit::last());
        $this->assertEquals(Number::Three, Number::last());
        $this->assertEquals(NonBackedNumber::Two, NonBackedNumber::last());
    }

    public function test_get_random_case_from_enhanced_enum(): void
    {
        $this->assertContains(Suit::getRandom(), Suit::cases());
        $this->assertContains(Number::getRandom(), Number::cases());
        $this->assertContains(NonBackedNumber::getRandom(), NonBackedNumber::cases());
    }
}
