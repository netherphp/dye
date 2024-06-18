<?php

namespace NetherTestSuite\Dye;

################################################################################
################################################################################

use PHPUnit;
use Nether\Dye;

################################################################################
################################################################################

class MainTest
extends PHPUnit\Framework\TestCase {

	const
	GryHex1 = '#404040',
	RedHex1 = '#FF0000',
	GrnHex1 = '#00FF00',
	BluHex1 = '#0000FF',
	YelHex1 = '#FFFF00',
	OrnHex1 = '#FF8800',
	NvyHex1 = '#123456',
	GldHex1 = '#F1C232',
	BlkHex1 = '#000000',
	WhiHex1 = '#FFFFFF';

	const
	GryHex1F = '#404040FF',
	RedHex1F = '#FF0000FF',
	GrnHex1F = '#00FF00FF',
	BluHex1F = '#0000FFFF',
	YelHex1F = '#FFFF00FF',
	OrnHex1F = '#FF8800FF',
	NvyHex1F = '#123456FF',
	GldHex1F = '#F1C232FF',
	BlkHex1F = '#000000FF',
	WhiHex1F = '#FFFFFFFF';

	const
	GryInt1 = 0x404040,
	RedInt1 = 0xFF0000,
	GrnInt1 = 0x00FF00,
	BluInt1 = 0x0000FF,
	YelInt1 = 0xFFFF00,
	OrnInt1 = 0xFF8800,
	NvyInt1 = 0x123456,
	GldInt1 = 0xF1C232,
	BlkInt1 = 0x000000,
	WhiInt1 = 0xFFFFFF;

	const
	GryInt1F = 0x404040FF,
	RedInt1F = 0xFF0000FF,
	GrnInt1F = 0x00FF00FF,
	BluInt1F = 0x0000FFFF,
	YelInt1F = 0xFFFF00FF,
	OrnInt1F = 0xFF8800FF,
	NvyInt1F = 0x123456FF,
	GldInt1F = 0xF1C232FF,
	BlkInt1F = 0x000000FF,
	WhiInt1F = 0xFFFFFFFF;

	const
	RedHSL1 = [ 0,   1.00, 0.50 ],
	GrnHSL1 = [ 120, 1.00, 0.50 ],
	BluHSL1 = [ 240, 1.00, 0.50 ],
	YelHSL1 = [ 60,  1.00, 0.50 ],
	OrnHSL1 = [ 32,  1.00, 0.50 ],
	NvyHSL1 = [ 210, 0.65, 0.20 ],
	GryHSL1 = [ 0,   0.00, 0.25 ],
	GldHSL1 = [ 45,  0.87, 0.57 ],
	BlkHSL1 = [ 0,   0.00, 0.00 ],
	WhiHSL1 = [ 0,   1.00, 1.00 ];

	const
	SweepRGB1 = [
		self::BlkHex1, self::GryHex1, self::WhiHex1,
		self::RedHex1, self::GrnHex1, self::BluHex1,
		self::YelHex1, self::OrnHex1, self::NvyHex1,
		self::GldHex1
	];

	const
	SweepRGB1F = [
		self::BlkHex1F, self::GryHex1F, self::WhiHex1F,
		self::RedHex1F, self::GrnHex1F, self::BluHex1F,
		self::YelHex1F, self::OrnHex1F, self::NvyHex1F,
		self::GldHex1F
	];

	const
	SweepInt1 = [
		self::BlkInt1, self::GryInt1, self::WhiInt1,
		self::RedInt1, self::GrnInt1, self::BluInt1,
		self::YelInt1, self::OrnInt1, self::NvyInt1,
		self::GldInt1
	];

	const
	SweepInt1F = [
		self::BlkInt1F, self::GryInt1F, self::WhiInt1F,
		self::RedInt1F, self::GrnInt1F, self::BluInt1F,
		self::YelInt1F, self::OrnInt1F, self::NvyInt1F,
		self::GldInt1F
	];

	const
	SweepHSL1 = [
		self::BlkHSL1, self::GryHSL1, self::WhiHSL1,
		self::RedHSL1, self::GrnHSL1, self::BluHSL1,
		self::YelHSL1, self::OrnHSL1, self::NvyHSL1,
		self::GldHSL1
	];

	////////////////////////////////////////////////////////////////
	// COLOUR READING //////////////////////////////////////////////

	#[PHPUnit\Framework\Attributes\Test]
	public function
	FromHexString():
	void {

		$Key = NULL;
		$RGB = NULL;
		$C = NULL;

		////////

		foreach(static::SweepRGB1 as $Key => $RGB) {
			$C = Dye\Colour::FromHexString($RGB);
			$this->AssertEquals(static::SweepRGB1[$Key], $C->ToHexRGB());
			$this->AssertEquals(static::SweepRGB1F[$Key], $C->ToHexRGBA());
		}

		foreach(static::SweepRGB1F as $Key => $RGB) {
			$C = Dye\Colour::FromHexString($RGB);
			$this->AssertEquals(static::SweepRGB1[$Key], $C->ToHexRGB());
			$this->AssertEquals(static::SweepRGB1F[$Key], $C->ToHexRGBA());
		}

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	FromStyleRGB():
	void {

		$RGB = NULL;
		$T = NULL;
		$C = NULL;

		////////

		foreach(static::SweepRGB1 as $RGB) {
			$T = Dye\Colour::FromHexString($RGB);
			$C = Dye\Colour::FromStyleRGB($T->ToStyleRGB());

			$this->AssertEquals($T->ToHexRGB(), $C->ToHexRGB());
			$this->AssertEquals($T->ToHexRGBA(), $C->ToHexRGBA());
		}

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	FromStyleRGBA():
	void {

		$RGB = NULL;
		$T = NULL;
		$C = NULL;

		////////

		foreach(static::SweepRGB1 as $RGB) {
			$T = Dye\Colour::FromHexString($RGB);
			$C = Dye\Colour::FromStyleRGBA($T->ToStyleRGBA());

			$this->AssertEquals($T->ToHexRGB(), $C->ToHexRGB());
			$this->AssertEquals($T->ToHexRGBA(), $C->ToHexRGBA());
		}

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	FromStyleHSL():
	void {

		$Fuzz = 2.0;
		$RGB = NULL;
		$T = NULL;
		$C = NULL;

		////////

		foreach(static::SweepRGB1 as $RGB) {
			$T = Dye\Colour::FromHexString($RGB);
			$C = Dye\Colour::FromStyleHSL($T->ToStyleHSL());

			$this->AssertEqualsWithDelta($T->R(), $C->R(), $Fuzz);
			$this->AssertEqualsWithDelta($T->G(), $C->G(), $Fuzz);
			$this->AssertEqualsWithDelta($T->B(), $C->B(), $Fuzz);
			$this->AssertEqualsWithDelta($T->A(), $C->A(), $Fuzz);
		}

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestFromHexShort():
	void {

		$Short = [ '#123', '#1234' ];
		$Long = [ '#112233', '#11223344' ];

		$C = Dye\Colour::FromHexString($Short[0]);
		$this->AssertEquals($Long[0], $C->ToHexRGB());
		$this->AssertEquals("{$Long[0]}FF", $C->ToHexRGBA());

		$C = Dye\Colour::FromHexString($Short[1]);
		$this->AssertEquals($Long[0], $C->ToHexRGB());
		$this->AssertEquals($Long[1], $C->ToHexRGBA());

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestFromHexInvalidChar():
	void {

		// an invalid hex number.

		$Err = NULL;
		$Exp = FALSE;

		try { Dye\Colour::FromHexString('#OK'); }
		catch(\Throwable $Err) {
			$Exp = TRUE;
			$this->AssertInstanceOf(\Exception::class, $Err);
		}

		$this->AssertTrue($Exp);

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestFromHexInvalidLen():
	void {

		// an invalid hex colour length.

		$Err = NULL;
		$Exp = FALSE;

		try { Dye\Colour::FromHexString('#Ad'); }
		catch(\Throwable $Err) {
			$Exp = TRUE;
			$this->AssertInstanceOf(\Exception::class, $Err);
		}

		$this->AssertTrue($Exp);

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestFromIntRGB():
	void {

		$Key = NULL;
		$RGB = NULL;
		$C = NULL;

		////////

		foreach(static::SweepInt1 as $Key => $RGB) {
			$C = Dye\Colour::FromIntRGB($RGB);
			$this->AssertEquals(static::SweepInt1[$Key], $C->ToIntRGB());
			$this->AssertEquals(static::SweepInt1F[$Key], $C->ToIntRGBA());
		}

		foreach(static::SweepInt1F as $Key => $RGB) {
			$C = Dye\Colour::FromIntRGBA($RGB);
			$this->AssertEquals(static::SweepInt1[$Key], $C->ToIntRGB());
			$this->AssertEquals(static::SweepInt1F[$Key], $C->ToIntRGBA());
		}

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestFromRGB():
	void {

		$Key = NULL;
		$RGB = NULL;
		$Bits = NULL;
		$C = NULL;

		////////

		foreach(static::SweepInt1 as $Key => $RGB) {
			$Bits = Dye\Util::DecToBitsRGB($RGB);
			$C = Dye\Colour::FromRGBA($Bits[0], $Bits[1], $Bits[2]);
			$this->AssertEquals(static::SweepInt1[$Key], $C->ToIntRGB());
			$this->AssertEquals(static::SweepInt1F[$Key], $C->ToIntRGBA());
		}

		foreach(static::SweepInt1F as $Key => $RGB) {
			$Bits = Dye\Util::DecToBitsRGBA($RGB);
			$C = Dye\Colour::FromRGBA($Bits[0], $Bits[1], $Bits[2], $Bits[3]);
			$this->AssertEquals(static::SweepInt1[$Key], $C->ToIntRGB());
			$this->AssertEquals(static::SweepInt1F[$Key], $C->ToIntRGBA());
		}

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestFromHSL():
	void {

		$Fuzz = 2;
		$Key = NULL;
		$HSL = NULL;

		$Chsl = NULL;
		$Crgb = NULL;

		////////

		foreach(static::SweepHSL1 as $Key => $HSL) {

			// check values
			$Chsl = Dye\Colour::FromHSL($HSL[0], $HSL[1], $HSL[2]);
			$this->AssertEquals($HSL[0], $Chsl->H());
			$this->AssertEquals($HSL[1], $Chsl->S());
			$this->AssertEquals($HSL[2], $Chsl->L());
			$this->AssertEquals(255, $Chsl->A());

			// sanity check rgb values
			$Crgb = Dye\Colour::FromHexString(static::SweepRGB1[$Key]);
			$this->AssertEqualsWithDelta($Crgb->R(), $Chsl->R(), $Fuzz);
			$this->AssertEqualsWithDelta($Crgb->G(), $Chsl->G(), $Fuzz);
			$this->AssertEqualsWithDelta($Crgb->B(), $Chsl->B(), $Fuzz);
			$this->AssertEqualsWithDelta($Crgb->A(), $Chsl->A(), $Fuzz);

		}

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestFromYoloImport():
	void {

		$C = new Dye\Colour;

		$C->Import('#FF0000');
		$this->AssertEquals('#FF0000', $C->ToHexRGB());

		$C->Import('#FF000088');
		$this->AssertEquals('#FF000088', $C->ToHexRGBA());

		$C->Import('rgb(0, 255, 0)');
		$this->AssertEquals('#00FF00', $C->ToHexRGB());

		$C->Import('rgba(0, 0, 255, 0.5)');
		$this->AssertEquals('#0000FF7F', $C->ToHexRGBA());

		$C->Import('hsl(0, 1.0, 0.5)');
		$this->AssertEquals('#FF0000', $C->ToHexRGB());

		$C->Import([ 255, 255, 0 ], $C::TypeRGB);
		$this->AssertEquals('#FFFF00', $C->ToHexRGB());

		$C->Import([ 255, 255, 0, 127 ], $C::TypeRGBA);
		$this->AssertEquals('#FFFF007F', $C->ToHexRGBA());

		$C->Import([ 120, 1.0, 0.5 ], $C::TypeHSL);
		$this->AssertEquals('#00FF00', $C->ToHexRGB());

		$C->Import(0x00FFFF, $C::TypeRGB);
		$this->AssertEquals('#00FFFF', $C->ToHexRGB());

		$C->Import(0x00FFFF7F, $C::TypeRGBA);
		$this->AssertEquals('#00FFFF7F', $C->ToHexRGBA());

		return;
	}

	////////////////////////////////////////////////////////////////
	// QUERY API ///////////////////////////////////////////////////

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestLightDark():
	void {

		$Colours = [
			'#FFFFFF' => TRUE,
			'#000000' => FALSE
		];

		$C = NULL;
		$Colour = NULL;
		$Bright = NULL;

		////////

		foreach($Colours as $Colour => $Bright) {
			$C = Dye\Colour::FromHexString($Colour);
			$this->AssertEquals($Bright, $C->IsBright());
			$this->AssertEquals(!$Bright, $C->IsDark());
		}

		return;
	}

	////////////////////////////////////////////////////////////////
	// MANIPULATION API ////////////////////////////////////////////

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestHueRotateShift():
	void {

		$Col = Dye\Colour::FromHSL(...static::RedHSL1);
		$this->AssertEquals(0, $Col->H());

		// basic rotations by degrees.

		$Col->HueRotate(120);
		$this->AssertEquals(120, $Col->H());

		$Col->HueRotate(120);
		$this->AssertEquals(240, $Col->H());

		$Col->HueRotate(120);
		$this->AssertEquals(0, $Col->H());

		$Col->HueRotate(-120);
		$this->AssertEquals(240, $Col->H());

		$Col->HueRotate(-120);
		$this->AssertEquals(120, $Col->H());

		$Col->HueRotate(-120);
		$this->AssertEquals(0, $Col->H());

		// basic rotations by percentage.

		$Col->HueShift(0.3334);
		$this->AssertEquals(120, $Col->H());

		$Col->HueShift(0.3334);
		$this->AssertEquals(240, $Col->H());

		$Col->HueShift(0.3334);
		$this->AssertEquals(0, $Col->H());

		$Col->HueShift(-0.3334);
		$this->AssertEquals(240, $Col->H());

		$Col->HueShift(-0.3334);
		$this->AssertEquals(120, $Col->H());

		$Col->HueShift(-0.3334);
		$this->AssertEquals(0, $Col->H());

		// rotations that overflow the number of degrees.

		$Col->HueRotate(120 * 4);
		$this->AssertEquals(120, $Col->H());

		$Col->HueRotate(-120 * 4);
		$this->AssertEquals(0, $Col->H());

		$Col->HueShift(0.3334 * 4);
		$this->AssertEquals(120, $Col->H());

		$Col->HueShift(-0.3334 * 4);
		$this->AssertEquals(0, $Col->H());

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestSaturationShift():
	void {

		$C = Dye\Colour::FromHexString('#FF0000');
		$C->Saturation(0.5);
		$this->AssertEquals('#BF4040', $C->ToHexRGB());

		$C->Saturation(2.0);
		$this->AssertEquals('#FF0000', $C->ToHexRGB());

		$C->Saturation(0.0);
		$this->AssertEquals('#7F7F7F', $C->ToHexRGB());

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestLightnessShift():
	void {

		$C = Dye\Colour::FromHexString('#FF0000');

		$C->Lightness(0.5);
		$this->AssertEquals('#800000', $C->ToHexRGB());

		$C->Lightness(2.0);
		$this->AssertEquals('#FF0000', $C->ToHexRGB());

		$C->Lightness(0.0);
		$this->AssertEquals('#000000', $C->ToHexRGB());

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestDarkenLighten():
	void {

		$C = Dye\Colour::FromHexString('#FF0000');

		$C->Darken(0.5);
		$this->AssertEquals('#800000', $C->ToHexRGB());

		$C->Lighten(1.0);
		$this->AssertEquals('#FF0000', $C->ToHexRGB());

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestLightenDarken():
	void {

		$C = Dye\Colour::FromHexString('#FF0000');

		$C->Lighten(0.5);
		$this->AssertEquals('#FF8080', $C->ToHexRGB());

		$C->Darken(0.3334);
		$this->AssertEquals('#FF0000', $C->ToHexRGB());

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestDesatSat():
	void {

		$C = Dye\Colour::FromHexString('#FF0000');

		$C->Desaturate(0.5);
		$this->AssertEquals('#BF4040', $C->ToHexRGB());

		$C->Saturate(1.0);
		$this->AssertEquals('#FF0000', $C->ToHexRGB());

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestSatDesat():
	void {

		$C = Dye\Colour::FromHexString('#BF4040');

		$C->Saturate(1.0);
		$this->AssertEquals('#FF0000', $C->ToHexRGB());

		$C->Desaturate(0.5);
		$this->AssertEquals('#BF4040', $C->ToHexRGB());

		return;
	}

	////////////////////////////////////////////////////////////////
	// TO STRING API ///////////////////////////////////////////////

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestToStyles():
	void {

		$C = Dye\Colour::FromIntRGB(static::NvyInt1);
		$RGB = Dye\Util::DecToBitsRGB(static::NvyInt1);

		$this->AssertEquals(
			static::NvyHex1,
			$C->ToHexRGB()
		);

		$this->AssertEquals(
			sprintf('hsl(%d, %.2f, %.2f)', static::NvyHSL1[0], static::NvyHSL1[1], static::NvyHSL1[2]),
			$C->ToStyleHSL()
		);

		$this->AssertEquals(
			sprintf('rgb(%d, %d, %d)', $RGB[0], $RGB[1], $RGB[2]),
			$C->ToStyleRGB()
		);

		$this->AssertEquals(
			sprintf('rgba(%d, %d, %d, 1.00)', $RGB[0], $RGB[1], $RGB[2]),
			$C->ToStyleRGBA()
		);

		return;
	}

};
