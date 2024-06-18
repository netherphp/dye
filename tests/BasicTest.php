<?php

namespace NetherTestSuite\Dye;

################################################################################
################################################################################

use PHPUnit;
use Nether\Dye;

use Throwable;

################################################################################
################################################################################

class BasicTest
extends PHPUnit\Framework\TestCase {

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestUtilDecToBitsRGB():
	void {

		$RGB = [ 1, 2, 3 ];
		$Bits = Dye\Util::DecToBitsRGB(0x010203);
		$Key = NULL;
		$Val = NULL;

		foreach($RGB as $Key => $Val)
		$this->AssertEquals($Val, $Bits[$Key]);

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestUtilDecToBitsRGBA():
	void {

		$RGBA = [ 1, 2, 3, 4 ];
		$Bits = Dye\Util::DecToBitsRGBA(0x01020304);
		$Key = NULL;
		$Val = NULL;

		foreach($RGBA as $Key => $Val)
		$this->AssertEquals($Val, $Bits[$Key]);

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestUtilShortToBitsRGB():
	void {

		$RGB = [ 0x11, 0x22, 0x33 ];
		$Bits = Dye\Util::ShortToBitsRGB(0x123);
		$Key = NULL;
		$Val = NULL;

		foreach($RGB as $Key => $Val)
		$this->AssertEquals($Val, $Bits[$Key]);

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestUtilShortToBitsRGBA():
	void {

		$RGB = [ 0x11, 0x22, 0x33, 0x44 ];
		$Bits = Dye\Util::ShortToBitsRGBA(0x1234);
		$Key = NULL;
		$Val = NULL;

		foreach($RGB as $Key => $Val)
		$this->AssertEquals($Val, $Bits[$Key]);

		return;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestUtilClampByte():
	void {

		$Input = [
			[    0,   0 ],
			[  100, 100 ],
			[  200, 200 ],
			[  300, 255 ],
			[  400, 255 ],
			[ -100,   0 ],
			[ -400,   0 ]
		];

		$Value = NULL;

		foreach($Input as $Value)
		$this->AssertEquals($Value[1], Dye\Util::ClampByte($Value[0]));

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestUtilClampNormal():
	void {

		$Input = [
			[  0.0, 0.0 ],
			[  0.5, 0.5 ],
			[  1.0, 1.0 ],
			[ -1.0, 0.0 ],
			[ -0.5, 0.0 ],
			[  1.5, 1.0 ]
		];

		$Value = NULL;

		foreach($Input as $Value)
		$this->AssertEquals($Value[1], Dye\Util::ClampNormal($Value[0]));

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestUtilWrapDegrees():
	void {

		$Input = [
			[    0,   0 ],
			[  120, 120 ],
			[  240, 240 ],
			[  360,   0 ],
			[  480, 120 ],
			[ -120, 240 ],
			[ -240, 120 ],
			[ -360,   0 ],
			[ -480, 240 ]
		];

		$Value = NULL;

		foreach($Input as $Value)
		$this->AssertEquals($Value[1], Dye\Util::WrapDegrees($Value[0]));

		return;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestMethodsFormatRGBA():
	void {

		$Fmt = new Dye\Format\RGBA;
		$this->AssertEquals(0, $Fmt->R());

		$Fmt->R(1);
		$Fmt->G(2);
		$Fmt->B(3);
		$Fmt->A(4);

		$this->AssertEquals(1, $Fmt->R());
		$this->AssertEquals(2, $Fmt->G());
		$this->AssertEquals(3, $Fmt->B());
		$this->AssertEquals(4, $Fmt->A());

		return;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestFormatValidArrayRGBA():
	void {

		$Format = new Dye\Format\RGBA;
		$Err = NULL;
		$Exp = FALSE;

		try {
			$Format->ImportArrayRGBA([1, 2, 3]);
			$this->AssertEquals(1, $Format->R());
			$this->AssertEquals(2, $Format->G());
			$this->AssertEquals(3, $Format->B());
			$this->AssertEquals(255, $Format->A());
		}

		catch(Throwable $Err) { $Exp = TRUE; }

		$this->AssertFalse($Exp);
		$this->AssertNull($Err);

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestFormatInvalidArrayRGBA1():
	void {

		$Format = new Dye\Format\RGBA;
		$Err = NULL;
		$Exp = FALSE;

		try {
			$Format->ImportArrayRGBA([1, 2]);
			$this->AssertEquals(1, $Format->R());
			$this->AssertEquals(2, $Format->G());
			$this->AssertEquals(3, $Format->B());
			$this->AssertEquals(255, $Format->A());
		}

		catch(Throwable $Err) { $Exp = TRUE; }

		$this->AssertTRUE($Exp);
		$this->AssertNotNull($Err);

		return;
	}

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestFormatInvalidArrayRGBA2():
	void {

		$Format = new Dye\Format\RGBA;
		$Err = NULL;
		$Exp = FALSE;

		try {
			$Format->ImportArrayRGBA([1, 2, 3, 4, 5]);
			$this->AssertEquals(1, $Format->R());
			$this->AssertEquals(2, $Format->G());
			$this->AssertEquals(3, $Format->B());
			$this->AssertEquals(255, $Format->A());
		}

		catch(Throwable $Err) { $Exp = TRUE; }

		$this->AssertTRUE($Exp);
		$this->AssertNotNull($Err);

		return;
	}

};
