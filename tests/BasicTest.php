<?php

namespace NetherTestSuite\Dye;

use Nether\Dye;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BasicTest
extends TestCase {

	#[Test]
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

	#[Test]
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

	#[Test]
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

};
