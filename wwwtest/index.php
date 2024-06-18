<?php

$AppRoot = dirname(__FILE__, 2);
require(sprintf('%s/vendor/autoload.php', $AppRoot));

$ColourSet = [
	'#FF0000', '#00FF00', '#0000FF',
	'#FF8800', '#F1C232', '#123456'
];

################################################################################
################################################################################

class BurnRow {

	public Nether\Dye\Colour
	$C;

	public function
	__Construct(string $Hex) {
		$this->C = Nether\Dye\Colour::From($Hex);
		return;
	}

	public function
	GenRotateData():
	array {

		$Output = array_fill(0, 11, NULL);
		$Key = NULL;

		for($Key = 0; $Key < count($Output); $Key++) {
			$Output[$Key] = Nether\Dye\Colour::FromIntRGB($this->C->ToIntRGB());
			$Output[$Key]->HueShift(1.0 - ($Key * 0.1));
		}

		return $Output;
	}

	public function
	GenDesatData():
	array {

		$Output = array_fill(0, 11, NULL);
		$Key = NULL;

		for($Key = 0; $Key < count($Output); $Key++) {
			$Output[$Key] = Nether\Dye\Colour::FromIntRGB($this->C->ToIntRGB());
			$Output[$Key]->Saturation(1.0 - ($Key * 0.1));
		}

		return $Output;
	}

	public function
	GenDarkenData():
	array {

		$Output = array_fill(0, 11, NULL);
		$Key = NULL;

		for($Key = 0; $Key < count($Output); $Key++) {
			$Output[$Key] = Nether\Dye\Colour::FromIntRGB($this->C->ToIntRGB());
			$Output[$Key]->Darken($Key * 0.1);
		}

		return $Output;
	}

	public function
	GenLightenData():
	array {

		$Output = array_fill(0, 11, NULL);
		$Key = NULL;

		for($Key = 0; $Key < count($Output); $Key++) {
			$Output[$Key] = Nether\Dye\Colour::FromIntRGB($this->C->ToIntRGB());
			$Output[$Key]->Lighten($Key * 0.1);
		}

		return $Output;
	}

	public function
	Render(array $Data):
	string {

		ob_start();
		echo '<div class="burnrow">';

		$C = NULL;

		foreach($Data as $C) {
			/** @var Nether\Dye\Colour $C */
			printf(
				'<div style="background-color: %s; color: %s;">%s</div>',
				$C->ToHexRGB(),
				$C->IsDark() ? '#FFFFFF' : '#000000',
				$C->ToHexRGB()
			);
		}

		echo '</div>';
		return ob_get_clean();
	}

};

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Colour Test</title>

	<style type="text/css">
	body { font-family: 'Consolas', monospace; margin: 0px; padding: 1.5rem; }
	h1, h2, h3, h4 { line-height: 1.0rem; margin: 0px 0px 1.5rem 0px; padding: 0px; }
	h1 { font-size: 4rem; }
	h2 { font-size: 2.5rem; }
	hr { margin-top: 1.5rem; margin-bottom: 1.5rem; }

	.burnrow { display: flex; width: 100%; }
	.burnrow > div { padding: 0.25rem; flex-grow: 1; text-align: center; }
	.mb-4 { margin-bottom: 2.0rem; }
	</style>
</head>
<body>

<div class="mb-4">
	<h2>About Red</h2>
	<hr />
	<?php
	$Red = Nether\Dye\Colour::From('#FF0000');
	printf('<div><b>RGB Hex:</b> %s</div>', $Red->ToHexRGB());
	printf('<div><b>RGBA Hex:</b> %s</div>', $Red->ToHexRGBA());
	printf('<div><b>Style RGB:</b> %s</div>', $Red->ToStyleRGB());
	printf('<div><b>Style HSL:</b> %s</div>', $Red->ToStyleHSL());
	printf('<div><b>Dark/Light:</b> %s</div>', $Red->IsDark() ? 'Dark' : 'Bright');
	?>
</div>

<div class="mb-4">
	<h2>Manipulation Outputs</h2>
	<hr />

	<?php
	foreach($ColourSet as $ColourHex) {
		$Row = new BurnRow($ColourHex);
		echo $Row->Render($Row->GenRotateData());
		echo $Row->Render($Row->GenDesatData());
		echo $Row->Render($Row->GenDarkenData());
		echo $Row->Render($Row->GenLightenData());
		echo '<br />';
	}
	?>
</div>

</body>
</html>