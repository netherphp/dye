<?php

namespace NetherTestSuite\Dye;

################################################################################
################################################################################

use PHPUnit;
use Nether\Dye;

################################################################################
################################################################################

class BasicTest
extends PHPUnit\Framework\TestCase {

	#[PHPUnit\Framework\Attributes\Test]
	public function
	TestDecToBitsRGB():
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
	TestDecToBitsRGBA():
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
	TestShortToBitsRGB():
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
	TestShortToBitsRGBA():
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
	TestClampByte():
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
	TestClampNormal():
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
	TestWrapDegrees():
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

};
