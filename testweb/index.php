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
		$this->C = Nether\Dye\Colour::FromHexString($Hex);
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
	.burnrow { display: flex; width: 100%; }
	.burnrow > div { padding: 0.25rem; font-family: 'Consolas', monospace; flex-grow: 1; text-align: center; }
	.mb-4 { margin-bottom: 2.0rem; }
	</style>
</head>
<body>

<div class="burnrow mb-4">
	<?php
	$Red = Nether\Dye\Colour::FromHexString('#FF0000');
	printf('<div>RGB Hex: %s</div>', $Red->ToHexRGB());
	printf('<div>RGBA Hex: %s</div>', $Red->ToHexRGBA());
	printf('<div>Style RGB: %s</div>', $Red->ToStyleRGB());
	printf('<div>Style HSL: %s</div>', $Red->ToStyleHSL());
	?>
</div>

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

</body>
</html>