# Nether\Dye

[![Packagist](https://img.shields.io/packagist/v/netherphp/dye.svg?style=for-the-badge)](https://packagist.org/packages/netherphp/dye)
[![Build Status](https://img.shields.io/github/actions/workflow/status/netherphp/dye/phpunit.yml?style=for-the-badge)](https://github.com/netherphp/dye/actions)
[![codecov](https://img.shields.io/codecov/c/gh/netherphp/dye?style=for-the-badge&token=VQC48XNBS2)](https://codecov.io/gh/netherphp/dye)

Simple colour manipulation.

# Usage

### `Nether\Dye\Colour`

Basic colour object where modifications will be mixed into the current object and all relevant properties recalculated to remain current.

### `Nether\Dye\ColourImmutable`

This version will return a fresh immutable colour when mixing in modifications leaving the original object untouched.

```php
$C = Nether\Dye\Colour::FromString('#FF0000');

echo $C->ToHexRGB(), PHP_EOL;
// #FF0000

echo $C->ToStyleRGB(), PHP_EOL;
// rgb(255, 0, 0)

echo $C->ToStyleHSL(), PHP_EOL;
// hsl(255, 0, 0)

echo ($C->IsDark() ? 'Dark' : 'Bright'), PHP_EOL;
// Bright

$C->HueRotate(120);
echo $C->ToHexRGB(), PHP_EOL;
// #00FF00

```
