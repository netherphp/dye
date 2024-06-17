<?php

namespace NetherTestSuite\Dye;

use Nether\Dye;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MainTest
extends TestCase {

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
	////////////////////////////////////////////////////////////////

	#[Test]
	public function
	FromHexString():
	void {

		$this->AssertTrue(TRUE);

		return;
	}

};
