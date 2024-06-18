# Nether\Dye

[![Packagist](https://img.shields.io/packagist/v/netherphp/dye.svg?style=for-the-badge)](https://packagist.org/packages/netherphp/dye)
[![Build Status](https://img.shields.io/github/actions/workflow/status/netherphp/dye/phpunit.yml?style=for-the-badge)](https://github.com/netherphp/dye/actions)
[![codecov](https://img.shields.io/codecov/c/gh/netherphp/dye?style=for-the-badge&token=VQC48XNBS2)](https://codecov.io/gh/netherphp/dye)

Simple colour manipulation.

# Usage

```php

use Nether\Dye\Colour;

$Red = Colour::FromHexString('#FF0000');
printf('<div">%s</div>', $Red->ToHexRGB());
printf('<div">%s</div>', $Red->ToHexRGBA());
printf('<div">%s</div>', $Red->ToStyleRGB());
printf('<div">%s</div>', $Red->ToStyleHSL());

```
