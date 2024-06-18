# Nether\Dye

[![Packagist](https://img.shields.io/packagist/v/netherphp/dye.svg?style=for-the-badge)](https://packagist.org/packages/netherphp/dye)
[![Build Status](https://img.shields.io/github/actions/workflow/status/netherphp/dye/phpunit.yml?style=for-the-badge)](https://github.com/netherphp/dye/actions)
[![codecov](https://img.shields.io/codecov/c/gh/netherphp/dye?style=for-the-badge&token=VQC48XNBS2)](https://codecov.io/gh/netherphp/dye)

Simple colour manipulation.

# Usage

```php
$Red = Nether\Dye\Colour::FromHexString('#FF0000');
printf('<div><b>RGB Hex:</b> %s</div>', $Red->ToHexRGB());
printf('<div><b>RGBA Hex:</b> %s</div>', $Red->ToHexRGBA());
printf('<div><b>Style RGB:</b> %s</div>', $Red->ToStyleRGB());
printf('<div><b>Style HSL:</b> %s</div>', $Red->ToStyleHSL());
printf('<div><b>Dark/Light:</b> %s</div>', $Red->IsDark() ? 'Dark' : 'Bright');
```
