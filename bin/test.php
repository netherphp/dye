<?php

$AppRoot = dirname(__FILE__, 2);
require(sprintf('%s/vendor/autoload.php', $AppRoot));

////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////

function
PrintRow(string $Title, string $What) {
	echo $Title, ': ', $What, PHP_EOL;
	return;
};

////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////

// printing formats

$C = new Nether\Dye\Colour('#FF0000');
PrintRow('RGB', $C->ToHexRGB());
PrintRow('RGBA', $C->ToHexRGBA());
PrintRow('HSL', $C->ToStyleHSL());
PrintRow('HSLA', $C->ToStyleHSLA());
echo PHP_EOL;

// colour manipulation

$C->HueRotate(120)->Darken(0.25);

PrintRow('RGB', $C->ToHexRGB());
PrintRow('RGB Bits', sprintf(
	'R: %d, G: %d, B: %d, A: %d',
	$C->RGB->R(), $C->RGB->G(), $C->RGB->B(), $C->RGB->A()
));
PrintRow('HSL Bits', sprintf(
	'H: %d, S: %.2f, L: %.2f, A: %.2f',
	...$C->HSL->ToArray(FALSE)
));
echo PHP_EOL;

