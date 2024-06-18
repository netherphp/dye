# Nether\Dye

[![Packagist](https://img.shields.io/packagist/v/netherphp/dye.svg?style=for-the-badge)](https://packagist.org/packages/netherphp/dye)
[![Build Status](https://img.shields.io/github/actions/workflow/status/netherphp/dye/phpunit.yml?style=for-the-badge)](https://github.com/netherphp/dye/actions)
[![codecov](https://img.shields.io/codecov/c/gh/netherphp/dye?style=for-the-badge&token=VQC48XNBS2)](https://codecov.io/gh/netherphp/dye)

Simple colour formatting and manipulation.



# Usage

### `Nether\Dye\Colour`

Basic colour object where modifications will be mixed into the current object and all relevant properties recalculated to remain current.

### `Nether\Dye\ColourImmutable`

This version will return a fresh immutable colour when mixing in modifications leaving the original object untouched.

# Factory API

**`Colour::From(string|RGBA|HSLA $Input): static`**
* Parse input colour from strings fitting known formats.

**`Colour::FromIntRGB(int $RGB): static`**
* Parse input colour from 24bit RGB integer.

**`Colour::FromIntRGBA(int $RGB): static`**
* Parse input colour from 32bit RGBA integer.

**`Colour::FromRGB(int $R, int $G, int $B, int|float $A=255): static`**
* Parse RGB by component.

**`Colour::FromHSL(int $H, float $S, float $L, float $A=1.0): static`**
* Parse HSL by component.

# Manipulation API

#### Setting Components

**`$Colour->SetRGB(?int $R, ?int $G, ?int $B, ?int $A): self`**
* Set any of the RGB[A] components that are specified and not null.

**`$Colour->SetHSL(?int $H, ?float $S, ?float $L, ?float $A): self`**
* Set any of the HSL[A] components that are specified and not null.

#### Shooping Around.

**`$Colour->HueRotate(int $Degrees): self`**
* Hue rotate a colour the specified number of degrees.

**`$Colour->HueShift(float $Percent): self`**
* Hue rotate a colour shifted over by the specified percentage.

**`$Colour->Saturation(float $Mult): self`**
* Modify the saturation of the colour by the specified multiplier.

**`$Colour->Saturate(float $Str): self`**
* Increase the saturation by the specified strength.

**`$Colour->Desaturate(float $Str): self`**
* Reduce the saturation by the specified strength.

**`$Colour->Lightness(float $Mult): self`**
* Modify the lightness of the colour by the specified multiplier.

**`$Colour->Lighten(float $Str): self`**
* Increase the lightness by the specified strength.

**`$Colour->Darken(float $Str): self`**
* Reduce the lightness by the specified strength.

# Printing API

**`$Colour->ToHexRGB(): string`**
* Return a hex encoded string like `#FF0000`

**`$Colour->ToHexRGBA(): string`**
* Return a hex encoded string like `#FF0000FF`

**`$Colour->ToStyleRGB(): string`**
* Return a hex encoded string like `rgb(255, 0, 0)`

**`$Colour->ToStyleRGBA(): string`**
* Return a hex encoded string like `rgb(255, 0, 0, 1.00)`

**`$Colour->ToStyleHSL(): string`**
* Return a hex encoded string like `hsl(0, 1.00, 0.50)`

**`$Colour->ToStyleHSLA(): string`**
* Return a hex encoded string like `hsl(0, 1.00, 0.50, 1.0)`

# Format Component API

> Note: all manipulations should be done via the methods on the root colour
> object to keep the various properties in sync. The SetRGB() and SetHSL()
> methods accept optional labeled arguments and array splattering.

**`$Colour->RGB->ToArray(bool $Indexed=TRUE): array`**
* Return an indexed array or a list of RGB data.

**`$Colour->RGB->R(): int`**
* Return the Red component of the RGB data.

**`$Colour->RGB->G(): int`**
* Return the Green component of the RGB data.

**`$Colour->RGB->B(): int`**
* Return the Blue component of the RGB data.

**`$Colour->RGB->A(): int`**
* Return the Alpha component of the RGB data.

**`$Colour->HSL->ToArray(bool $Indexed=TRUE): array`**
* Return an indexed array or a list of HSL data.

**`$Colour->HSL->H(): int`**
* Return the Hue component of the HSL data.

**`$Colour->HSL->S(): float`**
* Return the Saturation component of the HSL data.

**`$Colour->HSL->L(): float`**
* Return the Lightness component of the HSL data.

**`$Colour->HSL->A(): float`**
* Return the Alpha component of the HSL data.

# Examples

> **Instantiation Choices**

```php
use Nether\Dye\Colour;

// long form
$C1 = new Colour;
$C1->Import('#aabbcc');

// condensed form
$C2 = new Colour('#aabbcc');

// factory form
$C3 = Colour::From('#aabbcc');
```

> **Immutables**

```php
use Nether\Dye\ColourImmutable;

$R = new ColourImmutable('#FF0000');
$G = $R->HueRotate(120);
$B = $G->HueRotate(120);

printf(
	'R: %s, G: %s, B: %s%s',
	$R->ToHexRGB(),
	$G->ToHexRGB(),
	$B->ToHexRGB(),
	PHP_EOL
);

// R: #FF0000, G: #00FF00, B: #0000FF
```

# Testing

**`$ phpunit`**
* Run the unit test suite.

**`$ php -S localhost:8080 -t wwwtest`**
* Run a test page to see some things.
