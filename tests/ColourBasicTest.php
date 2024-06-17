<?php

namespace NetherTestSuite\Dye;

use Nether\Dye;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ColourBasicTest
extends TestCase {

	#[Test]
	public function
	FromHexString():
	void {

		$C = Dye\Colour::FromHexString('#FF0000');
		$this->AssertEquals('#FF0000', $C->ToHexRGB());

		return;
	}

};
