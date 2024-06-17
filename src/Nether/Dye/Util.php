<?php

namespace Nether\Dye;

class Util {

	const
	DegMax = 360,
	ByteMax = 255;

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	static public function
	DecToBitsRGB(int $Int):
	array {

		return [
			($Int & 0xFF0000) >> 16,
			($Int & 0x00FF00) >> 8,
			($Int & 0x0000FF) >> 0
		];
	}

	static public function
	DecToBitsRGBA(int $Int):
	array {

		return [
			($Int & 0xFF000000) >> 24,
			($Int & 0x00FF0000) >> 16,
			($Int & 0x0000FF00) >> 8,
			($Int & 0x000000FF) >> 0
		];
	}

	static public function
	ShortToBitsRGB(int $Int):
	array {

		return [
			(($Int & 0xF00) >> 8) | (($Int & 0xF00) >> 4),
			(($Int & 0x0F0) >> 4) | (($Int & 0x0F0) >> 0),
			(($Int & 0x00F) >> 0) | (($Int & 0x00F) << 4)
		];
	}

	static public function
	ShortToBitsRGBA(int $Int):
	array {

		return [
			(($Int & 0xF000) >> 12) | (($Int & 0xF000) >> 8),
			(($Int & 0x0F00) >> 8)  | (($Int & 0x0F00) >> 4),
			(($Int & 0x00F0) >> 4)  | (($Int & 0x00F0) >> 0),
			(($Int & 0x000F) >> 0)  | (($Int & 0x000F) << 4)
		];
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	static public function
	ClampByte(int|float $Num):
	int {

		return min(max((int)$Num, 0), static::ByteMax);
	}

	static public function
	ClampNormal(float $Val):
	float {

		return min(max($Val, 0.0), 1.0);
	}

	static public function
	WrapDegrees(int|float $Deg):
	int {

		$Wrapped = ((int)round($Deg, 0)) % static::DegMax;

		if($Wrapped < 0)
		$Wrapped += static::DegMax;

		return $Wrapped;
	}

};
