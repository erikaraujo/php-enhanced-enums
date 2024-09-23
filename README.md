# php-enhanced-enums
Enhanced Enum methods for PHP Enums

In this package, we have 4 traits: `EnhancedEnum`, `HasDescription`, `HasLabel` and `IsSelectArray`. Here are all the methods that each trait provides:

- [EnhancedEnum](#enhancedenum)
    - [`parse()`](#parse)
    - [`tryParse()`](#tryparse)
    - [`tryFromIgnoringCase()`](#tryfromignoringcase)
    - [`tryParseIgnoringCase()`](#tryparseignoringcase)
    - [`getNames()`](#getnames)
    - [`getValues()`](#getvalues)
    - [`isDefined()`](#isdefined)
    - [`toString()`](#tostring)
    - [`is()`](#is)
    - [`getBackingType()`](#getbackingtype)
    - [`getUnderlyingType()`](#getunderlyingtype)
    - [`isIntEnum()`](#isintenum)
    - [`isStringEnum()`](#isstringenum)
    - [`getRandom()`](#getrandom)
    - [`getCaseByPosition()`](#getcasebyposition)
    - [`tryGetCaseByPosition()`](#trygetcasebyposition)
    - [`first()`](#first)
    - [`last()`](#last)
- [HasDescription](#hasdescription)
    - [`getDescription()`](#getdescription)
    - [`getDescriptions()`](#getdescriptions)
    - [`tryFromDescription()`](#tryfromdescription)
    - [`tryFromDescriptionIgnoringCase()`](#tryfromdescriptionignoringcase)
- [HasLabel](#haslabel)
    - [`getLabel()`](#getlabel)
    - [`getLabels()`](#getlabels)
    - [`tryFromLabel()`](#tryfromlabel)
    - [`tryFromLabelIgnoringCase()`](#tryfromlabelignoringcase)
    - [`shouldAutoGenerateLabelFromValue()`](#shouldautogeneratelabelfromvalue)
- [IsSelectArray](#isselectarray)
    - [`asSelectArray()`](#asselectarray)


## EnhancedEnum

### `parse()`
This method is simply an alias to the native `from()` method. Here's an example:

```php
Suit::parse('hearts'); // Returns the Suit::Hearts case

Suit::parse('invalid'); // Throws an exception
```

### `tryParse()`
This method is an improved alias to the `tryFrom()` method. The difference here, is that, instead of only having the `$value` parameter, it also has a `$ignoreCase` boolean parameter to allow the method to ignore the case of the value before parsing it. Here's an example:

```php
Suit::tryParse('hearts'); // Returns the Suit::Hearts case

Suit::tryParse('invalid'); // Returns null

Suit::tryParse('hEaRtS'); // Returns null

Suit::tryParse('hEaRtS', ignoreCase: true); // Returns the Suit::Hearts case
```

### `tryFromIgnoringCase()`
// TODO

### `tryParseIgnoringCase()`
An alias to `tryFromIgnoreCase()`.

### `getNames()`
This method returns an array with all the names of the enum cases. Here's an example:

```php
Suit::getNames(); // Returns ['Hearts', 'Diamonds', 'Clubs', 'Spades']
```

### `getValues()`
This method returns an array with all the values of the enum cases. Here's an example:

```php
Suit::getValues(); // Returns ['hearts', 'diamonds', 'clubs', 'spades']
```

### `isDefined()`
This method checks if a given value is defined in the enum. Here's an example:

```php
Suit::isDefined('hearts'); // Returns true

Suit::isDefined('invalid'); // Returns false

Suit::isDefined('hEaRtS'); // Returns false

Suit::isDefined('hEaRtS', ignoreCase: true); // Returns true
```

### `toString()`
This method returns the value of the enum as string - even if it's an integer enum.

### `is()`
TODO: describe

```php
Suit::Hearts->is(Suit::Spades); // Returns `false`
Suit::Hearts->is('spades'); // Returns `false`

Suit::Hearts->is(Suit::Hearts); // Returns `true`
Suit::Hearts->is('hearts'); // Returns `true`
Suit::Hearts->is('HeArTs'); // Returns `false`
Suit::Hearts->is('HeArTs', ignoreCase: true); // Returns `true`
```

### `getBackingType()`
// TODO: describe

```php
Suits::getBackingType(); // returns the `ReflectionNamedType`. In this case, with `string` as a `name`.
```

### `getUnderlyingType()`
An alias to `getBackingType()`

### `isIntEnum()`
Returns if the enum's backing type is an integer.

```php
Suit::isIntEnum(); // Returns false
```

### `isStringEnum()`
Returns if the enum's backing type is a string.

```php
Suit::isStringEnum(); // Returns true
```

### `getRandom()`
Returns a random enum case.

### `getCaseByPosition()`

```php
```

### `tryGetCaseByPosition()`

```php
```

### `first()`

```php
```

### `last()`

```php
```

## HasDescription

### `getDescription()`
Returns the description of the given enum

```php
Suit::Hearts->getDescription(); // Returns "The suit of hearts"
```

### `getDescriptions()`
Returns an array of all the descriptions

```php
Suit::getDescriptions();
```

### `tryFromDescription()`

```php
```

### `tryFromDescriptionIgnoringCase()`

```php
```

## HasLabel

### `getLabel()`

```php
```

### `getLabels()`

```php
```

### `tryFromLabel()`

```php
```

### `tryFromLabelIgnoringCase()`

```php
```

### `shouldAutoGenerateLabelFromValue()`

`protected`

```php
```

## IsSelectArray

### `asSelectArray()`

```php
```