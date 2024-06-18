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
			$C = Dye\Colour::From($RGB);
			$this->AssertEquals(static::SweepRGB1[$Key], $C->ToHexRGB());
			$this->AssertEquals(static::SweepRGB1F[$Key], $C->ToHexRGBA());
		}

		foreach(static::SweepRGB1F as $Key => $RGB) {
			$C = Dye\Colour::From($RGB);
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
		$Err = NULL;

		////////

		foreach(static::SweepRGB1 as $RGB) {
			$T = Dye\Colour::From($RGB);
			$C = Dye\Colour::From($T->ToStyleRGB());

			$this->AssertEquals($T->ToHexRGB(), $C->ToHexRGB());
			$this->AssertEquals($T->ToHexRGBA(), $C->ToHexRGBA());
		}

		////////

		try { Dye\Colour::From('jljjaf'); }
		catch(Dye\Error\InvalidColourFormat $Err) { }

		$this->AssertInstanceOf(
			Dye\Error\InvalidColourFormat::class,
			$Err
		);

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	FromStyleRGBA():
	void {

		$RGB = NULL;
		$Err = NULL;
		$T = NULL;
		$C = NULL;

		////////

		foreach(static::SweepRGB1 as $RGB) {
			$T = Dye\Colour::From($RGB);
			$C = Dye\Colour::From($T->ToStyleRGBA());

			$this->AssertEquals($T->ToHexRGB(), $C->ToHexRGB());
			$this->AssertEquals($T->ToHexRGBA(), $C->ToHexRGBA());
		}

		////////

		try { Dye\Colour::From('jljjaf'); }
		catch(Dye\Error\InvalidColourFormat $Err) { }

		$this->AssertInstanceOf(
			Dye\Error\InvalidColourFormat::class,
			$Err
		);

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	FromStyleHSL():
	void {

		$Fuzz = 2.0;
		$RGB = NULL;
		$Err = NULL;
		$T = NULL;
		$C = NULL;

		////////

		foreach(static::SweepRGB1 as $RGB) {
			$T = Dye\Colour::From($RGB);
			$C = Dye\Colour::From($T->ToStyleHSL());

			$this->AssertEqualsWithDelta($T->RGB->R(), $C->RGB->R(), $Fuzz);
			$this->AssertEqualsWithDelta($T->RGB->G(), $C->RGB->G(), $Fuzz);
			$this->AssertEqualsWithDelta($T->RGB->B(), $C->RGB->B(), $Fuzz);
			$this->AssertEqualsWithDelta($T->RGB->A(), $C->RGB->A(), $Fuzz);
		}

		////////

		try { Dye\Colour::From('jljjaf'); }
		catch(Dye\Error\InvalidColourFormat $Err) { }

		$this->AssertInstanceOf(
			Dye\Error\InvalidColourFormat::class,
			$Err
		);

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestFromHexShort():
	void {

		$Short = [ '#123', '#1234' ];
		$Long = [ '#112233', '#11223344' ];

		$C = Dye\Colour::From($Short[0]);
		$this->AssertEquals($Long[0], $C->ToHexRGB());
		$this->AssertEquals("{$Long[0]}FF", $C->ToHexRGBA());

		$C = Dye\Colour::From($Short[1]);
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

		try { Dye\Colour::From('#OK'); }
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

		try { Dye\Colour::From('#Ad'); }
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
		$Cobj = NULL;

		////////

		foreach(static::SweepInt1 as $Key => $RGB) {
			$Bits = Dye\Util::DecToBitsRGB($RGB);
			$C = Dye\Colour::FromRGB($Bits[0], $Bits[1], $Bits[2]);
			$this->AssertEquals(static::SweepInt1[$Key], $C->ToIntRGB());
			$this->AssertEquals(static::SweepInt1F[$Key], $C->ToIntRGBA());

			// cobj values
			$Cobj = Dye\Colour::From($C->RGB);
			$this->AssertEquals($Cobj->RGB->R(), $C->RGB->R());
			$this->AssertEquals($Cobj->RGB->G(), $C->RGB->G());
			$this->AssertEquals($Cobj->RGB->B(), $C->RGB->B());
			$this->AssertEquals($Cobj->RGB->A(), $C->RGB->A());
		}

		foreach(static::SweepInt1F as $Key => $RGB) {
			$Bits = Dye\Util::DecToBitsRGBA($RGB);
			$C = Dye\Colour::FromRGB($Bits[0], $Bits[1], $Bits[2], $Bits[3]);
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
		$Cobj = NULL;

		////////

		foreach(static::SweepHSL1 as $Key => $HSL) {

			// check values
			$Chsl = Dye\Colour::FromHSL($HSL[0], $HSL[1], $HSL[2]);
			$this->AssertEquals($HSL[0], $Chsl->HSL->H());
			$this->AssertEquals($HSL[1], $Chsl->HSL->S());
			$this->AssertEquals($HSL[2], $Chsl->HSL->L());
			$this->AssertEquals(1.0, $Chsl->HSL->A());

			// sanity check rgb values
			$Crgb = Dye\Colour::From(static::SweepRGB1[$Key]);
			$this->AssertEqualsWithDelta($Crgb->RGB->R(), $Chsl->RGB->R(), $Fuzz);
			$this->AssertEqualsWithDelta($Crgb->RGB->G(), $Chsl->RGB->G(), $Fuzz);
			$this->AssertEqualsWithDelta($Crgb->RGB->B(), $Chsl->RGB->B(), $Fuzz);
			$this->AssertEqualsWithDelta($Crgb->RGB->A(), $Chsl->RGB->A(), $Fuzz);

			// cobj values
			$Cobj = Dye\Colour::From($Chsl->RGB);
			$this->AssertEquals($Cobj->RGB->R(), $Chsl->RGB->R());
			$this->AssertEquals($Cobj->RGB->G(), $Chsl->RGB->G());
			$this->AssertEquals($Cobj->RGB->B(), $Chsl->RGB->B());
			$this->AssertEquals($Cobj->RGB->A(), $Chsl->RGB->A());
		}

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestFromYoloImport():
	void {

		$C = new Dye\Colour;
		$N = NULL;
		$Err = NULL;

		////////

		$C->Import('#FF0000');
		$this->AssertEquals('#FF0000', $C->ToHexRGB());

		$N = Dye\Colour::From($C->ToHexRGB());
		$this->AssertEquals('#FF0000', $N->ToHexRGB());

		// ...

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

		////////

		$Err = NULL;

		try { $C->Import([ 1, 2 ], 'wrong'); }
		catch(Dye\Error\InvalidColourFormat $Err) { }

		$this->AssertInstanceOf(
			Dye\Error\InvalidColourFormat::class, $Err
		);

		////////

		$Err = NULL;

		try { $C->Import([ 1, 2 ]); }
		catch(Dye\Error\InvalidColourFormat $Err) { }

		$this->AssertInstanceOf(
			Dye\Error\InvalidColourFormat::class, $Err
		);

		////////

		$Err = NULL;

		try { $C->Import(123, 'wrong'); }
		catch(Dye\Error\InvalidColourFormat $Err) { }

		$this->AssertInstanceOf(
			Dye\Error\InvalidColourFormat::class, $Err
		);

		////////

		$Err = NULL;

		try { $C->Import(123); }
		catch(Dye\Error\InvalidColourFormat $Err) { }

		$this->AssertInstanceOf(
			Dye\Error\InvalidColourFormat::class, $Err
		);

		////////

		$Err = NULL;

		try { $C->Import('rgb(chicken, nuggets)'); }
		catch(Dye\Error\StyleRegexFail $Err) { }

		$this->AssertInstanceOf(
			Dye\Error\StyleRegexFail::class, $Err
		);

		////////

		$Err = NULL;

		try { $C->Import('rgba(chicken, nuggets)'); }
		catch(Dye\Error\StyleRegexFail $Err) { }

		$this->AssertInstanceOf(
			Dye\Error\StyleRegexFail::class, $Err
		);

		return;
	}

	////////////////////////////////////////////////////////////////
	// QUERY API ///////////////////////////////////////////////////

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestQueryLightDark():
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
			$C = Dye\Colour::From($Colour);
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
		$this->AssertEquals(0, $Col->HSL->H());

		// basic rotations by degrees.

		$Col->HueRotate(120);
		$this->AssertEquals(120, $Col->HSL->H());

		$Col->HueRotate(120);
		$this->AssertEquals(240, $Col->HSL->H());

		$Col->HueRotate(120);
		$this->AssertEquals(0, $Col->HSL->H());

		$Col->HueRotate(-120);
		$this->AssertEquals(240, $Col->HSL->H());

		$Col->HueRotate(-120);
		$this->AssertEquals(120, $Col->HSL->H());

		$Col->HueRotate(-120);
		$this->AssertEquals(0, $Col->HSL->H());

		// basic rotations by percentage.

		$Col->HueShift(0.3334);
		$this->AssertEquals(120, $Col->HSL->H());

		$Col->HueShift(0.3334);
		$this->AssertEquals(240, $Col->HSL->H());

		$Col->HueShift(0.3334);
		$this->AssertEquals(0, $Col->HSL->H());

		$Col->HueShift(-0.3334);
		$this->AssertEquals(240, $Col->HSL->H());

		$Col->HueShift(-0.3334);
		$this->AssertEquals(120, $Col->HSL->H());

		$Col->HueShift(-0.3334);
		$this->AssertEquals(0, $Col->HSL->H());

		// rotations that overflow the number of degrees.

		$Col->HueRotate(120 * 4);
		$this->AssertEquals(120, $Col->HSL->H());

		$Col->HueRotate(-120 * 4);
		$this->AssertEquals(0, $Col->HSL->H());

		$Col->HueShift(0.3334 * 4);
		$this->AssertEquals(120, $Col->HSL->H());

		$Col->HueShift(-0.3334 * 4);
		$this->AssertEquals(0, $Col->HSL->H());

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestSaturationShift():
	void {

		$C = Dye\Colour::From('#FF0000');
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

		$C = Dye\Colour::From('#FF0000');

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

		$C = Dye\Colour::From('#FF0000');

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

		$C = Dye\Colour::From('#FF0000');

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

		$C = Dye\Colour::From('#FF0000');

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

		$C = Dye\Colour::From('#BF4040');

		$C->Saturate(1.0);
		$this->AssertEquals('#FF0000', $C->ToHexRGB());

		$C->Desaturate(0.5);
		$this->AssertEquals('#BF4040', $C->ToHexRGB());

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestSetRGBA():
	void {

		$C = Dye\Colour::From('#000000');
		$this->AssertEquals('#000000', $C->ToHexRGB());

		$C->SetRGB(1, 2, 3, 4);
		$this->AssertEquals('#01020304', $C->ToHexRGBA());

		$C->SetRGB(R: 0xA1);
		$this->AssertEquals('#A1020304', $C->ToHexRGBA());

		$C->SetRGB(G: 0xB1);
		$this->AssertEquals('#A1B10304', $C->ToHexRGBA());

		$C->SetRGB(B: 0xC1);
		$this->AssertEquals('#A1B1C104', $C->ToHexRGBA());

		$C->SetRGB(A: 0xD1);
		$this->AssertEquals('#A1B1C1D1', $C->ToHexRGBA());

		// and i mean some crazy shit that you could be dumping into here
		// hapzichordicandantly.

		$C->SetRGB(...[ 'R'=> 0xBA, 'G'=> 0xBB ]);
		$this->AssertEquals('#BABBC1D1', $C->ToHexRGBA());

		// test that alpha is biscalar

		$C->SetRGB(A: 0.5);
		$this->AssertEquals('#BABBC17F', $C->ToHexRGBA());

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestSetHSL():
	void {

		$C = Dye\Colour::From('#000000');
		$this->AssertEquals('#000000', $C->ToHexRGB());

		$C->SetHSL(120, 1.0, 0.5);
		$this->AssertEquals('#00FF00', $C->ToHexRGB());

		$C->SetHSL(H: 240);
		$this->AssertEquals('#0000FF', $C->ToHexRGB());

		$C->SetHSL(S: 0.5);
		$this->AssertEquals('#4040BF', $C->ToHexRGB());

		$C->SetHSL(L: 0.75);
		$this->AssertEquals('#A1A1E0', $C->ToHexRGB());

		return;
	}

	////////////////////////////////
	////////////////////////////////

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestImmutableBasic():
	void {

		$R = new Dye\ColourImmutable('#FF0000');
		$G = $R->HueRotate(120);
		$B = $G->HueRotate(120);

		$this->AssertNotEquals(spl_object_id($R), spl_object_id($G));
		$this->AssertNotEquals(spl_object_id($G), spl_object_id($B));
		$this->AssertNotEquals(spl_object_id($B), spl_object_id($R));

		$this->AssertNotEquals($R->ToHexRGB(), $G->ToHexRGB());
		$this->AssertNotEquals($G->ToHexRGB(), $B->ToHexRGB());
		$this->AssertNotEquals($B->ToHexRGB(), $R->ToHexRGB());

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestImmutableMore():
	void {

		$Methods = [
			'Import'     => [ '#00FF00' ],
			'Import_2'   => [ [ 1, 2, 3 ], Dye\Colour::TypeRGB ],
			'Import_3'   => [ 0x0000FF, Dye\Colour::TypeRGB ],
			'Import_4'   => [ new Dye\Format\RGBA(4, 5, 6, 7) ],
			'SetRGB'     => [ 1, 2, 3, 4 ],
			'SetHSL'     => [ 10, 0.2, 0.3, 0.4 ],
			'HueRotate'  => [ 120 ],
			'HueShift'   => [ 0.25 ],
			'Saturation' => [ 1.25 ],
			'Saturate'   => [ 0.5 ],
			'Desaturate' => [ 0.5 ],
			'Lightness'  => [ 1.25 ],
			'Lighten'    => [ 0.5 ],
			'Darken'     => [ 0.5 ]
		];

		$BaseColour = '#FF0000';
		$C1 = NULL;
		$C2 = NULL;
		$Method = NULL;
		$Args = NULL;

		////////

		foreach($Methods as $Method => $Args) {
			$Method = rtrim($Method, '_0123456789');

			$C1 = Dye\Colour::From($BaseColour);
			$C2 = $C1->{$Method}(...$Args);
			$this->AssertEquals(spl_object_id($C1), spl_object_id($C2));

			$C1 = Dye\ColourImmutable::From($BaseColour);
			$C2 = $C1->{$Method}(...$Args);
			$this->AssertNotEquals(spl_object_id($C1), spl_object_id($C2));
		}

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

		////////

		$this->AssertEquals(
			static::NvyHex1,
			$C->ToHexRGB()
		);

		$this->AssertEquals(
			sprintf('hsl(%d, %.2f, %.2f)', static::NvyHSL1[0], static::NvyHSL1[1], static::NvyHSL1[2]),
			$C->ToStyleHSL()
		);

		$this->AssertEquals(
			sprintf('hsla(%d, %.2f, %.2f, 1.00)', static::NvyHSL1[0], static::NvyHSL1[1], static::NvyHSL1[2]),
			$C->ToStyleHSLA()
		);

		$this->AssertEquals(
			sprintf('rgb(%d, %d, %d)', $RGB[0], $RGB[1], $RGB[2]),
			$C->ToStyleRGB()
		);

		$this->AssertEquals(
			sprintf('rgba(%d, %d, %d, 1.00)', $RGB[0], $RGB[1], $RGB[2]),
			$C->ToStyleRGBA()
		);

		////////

		$this->AssertArrayIsEqualToArrayOnlyConsideringListOfKeys(
			[ 'R'=> $C->RGB->R(), 'G'=> $C->RGB->G(), 'B'=> $C->RGB->B(), 'A'=> $C->RGB->A() ],
			$C->RGB->ToArray(),
			[ 'R', 'G', 'B', 'A' ]
		);

		$this->AssertArrayIsEqualToArrayOnlyConsideringListOfKeys(
			[ $C->RGB->R(), $C->RGB->G(), $C->RGB->B(), $C->RGB->A() ],
			$C->RGB->ToArray(FALSE),
			[ 0, 1, 2, 3 ]
		);

		$this->AssertArrayIsEqualToArrayOnlyConsideringListOfKeys(
			[ 'H'=> $C->HSL->H(), 'S'=> $C->HSL->S(), 'L'=> $C->HSL->L(), 'A'=> $C->HSL->A() ],
			$C->HSL->ToArray(),
			[ 'H', 'S', 'L', 'A' ]
		);

		$this->AssertArrayIsEqualToArrayOnlyConsideringListOfKeys(
			[ $C->HSL->H(), $C->HSL->S(), $C->HSL->L(), $C->HSL->A() ],
			$C->HSL->ToArray(FALSE),
			[ 0, 1, 2, 3 ]
		);

		return;
	}

};
