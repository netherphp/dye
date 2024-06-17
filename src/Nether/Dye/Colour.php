<?php

namespace Nether\Dye;

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

class Colour {

	const
	DegMax = 360,
	ByteMax = 255;

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public Format\RGBA
	$RGBA;

	public Format\HSL
	$HSL;

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	__Construct() {

		$this->RGBA = new Format\RGBA;
		$this->HSL = new Format\HSL;

		return;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	R():
	int {

		return $this->RGBA->R;
	}

	public function
	G():
	int {

		return $this->RGBA->G;
	}

	public function
	B():
	int {

		return $this->RGBA->B;
	}

	public function
	A():
	int {

		return $this->RGBA->A;
	}

	public function
	H():
	int {

		return $this->HSL->H;
	}

	public function
	S():
	float {

		return $this->HSL->S;
	}

	public function
	L():
	float {

		return $this->HSL->L;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	HueRotate(int $Deg=0):
	static {

		$this->HSL->Rotate($Deg);
		$this->UpdateFromHSL();

		return $this;
	}

	public function
	HueShift(float $Per=0.0):
	static {

		$Deg = round((static::DegMax * $Per), 0);

		$this->HSL->Rotate($Deg);
		$this->UpdateFromHSL();

		return $this;
	}

	public function
	Saturate(float $Per=0.0):
	static {

		$this->HSL->Saturate($Per);
		$this->UpdateFromHSL();

		return $this;
	}

	public function
	Desaturate(float $Per=0.0):
	static {

		$this->HSL->Desaturate($Per);
		$this->UpdateFromHSL();

		return $this;
	}

	public function
	Lighten(float $Per=0.0):
	static {

		$this->HSL->Lighten($Per);
		$this->UpdateFromHSL();

		return $this;
	}

	public function
	Darken(float $Per=0.0):
	static {

		$this->HSL->Darken($Per);
		$this->UpdateFromHSL();

		return $this;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Saturation(float $Mult=1.0):
	static {

		$this->HSL->Saturation($Mult);
		$this->UpdateFromHSL();

		return $this;
	}

	public function
	Brightness(float $Mult=1.0):
	static {

		$this->HSL->Brightness($Mult);
		$this->UpdateFromHSL();

		return $this;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	ImportHexString(string $Hex):
	static {

		$Hex = ltrim($Hex, '#');
		$Len = strlen($Hex);

		if(preg_match('/[^0-9a-fA-F]/', $Hex))
		throw new \Exception('invalid hex string');

		////////

		$this->RGBA->ImportArrayRGBA(match(TRUE) {
			($Len === 8) => static::DecToBitsRGBA(hexdec($Hex)),
			($Len === 6) => [ ...static::DecToBitsRGB(hexdec($Hex)), 0xFF ],
			($Len === 4) => static::ShortToBitsRGBA(hexdec($Hex)),
			($Len === 3) => [ ...static::ShortToBitsRGB(hexdec($Hex)), 0xFF ],
			default      => throw new \Exception('invalid hex colour format')
		});

		////////

		$this->UpdateFromRGBA();

		return $this;
	}

	public function
	ImportIntRGB(int $Int):
	static {

		$this->RGBA->ImportArrayRGBA(static::DecToBitsRGB($Int));
		$this->UpdateFromRGBA();

		return $this;
	}

	public function
	ImportIntRGBA(int $Int):
	static {

		$this->RGBA->ImportArrayRGBA(static::DecToBitsRGBA($Int));
		$this->UpdateFromRGBA();

		return $this;
	}

	public function
	ImportRGBA(int $R, int $G, int $B, int $A=255):
	static {

		$this->RGBA->Set($R, $G, $B, $A);
		$this->UpdateFromRGBA();

		return $this;
	}

	public function
	ImportHSL(int $H, float $S, float $L):
	static {

		$this->HSL->Set($H, $S, $L);
		$this->RGBA->A = 0xFF;

		$this->UpdateFromHSL();

		return $this;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	protected function
	UpdateFromRGBA():
	static {

		$this->HSL->ImportRGBA($this->RGBA);

		return $this;
	}

	protected function
	UpdateFromHSL():
	static {

		$this->RGBA->ImportHSL($this->HSL);

		return $this;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	ToHexRGB():
	string {

		$Output = strtoupper(sprintf(
			'#%02x%02x%02x',
			$this->RGBA->R,
			$this->RGBA->G,
			$this->RGBA->B
		));

		return $Output;
	}

	public function
	ToHexRGBA():
	string {

		$Output = strtoupper(sprintf(
			'#%02x%02x%02x%02x',
			$this->RGBA->R,
			$this->RGBA->G,
			$this->RGBA->B,
			$this->RGBA->A
		));

		return $Output;
	}

	public function
	ToIntRGB():
	int {

		return (0
			| ($this->RGBA->R << 16)
			| ($this->RGBA->G << 8)
			| ($this->RGBA->B)
		);
	}

	public function
	ToIntRGBA():
	int {

		return (0
			| ($this->RGBA->R << 24)
			| ($this->RGBA->G << 16)
			| ($this->RGBA->B << 8)
			| ($this->RGBA->A)
		);
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	static public function
	FromHexString(string $RGBa):
	static {

		$Output = new static;
		$Output->ImportHexString($RGBa);

		return $Output;
	}

	static public function
	FromIntRGB(int $RGB):
	static {

		$Output = new static;
		$Output->ImportIntRGB($RGB);

		return $Output;
	}

	static public function
	FromIntRGBA(int $RGBA):
	static {

		$Output = new static;
		$Output->ImportIntRGBA($RGBA);

		return $Output;
	}

	static public function
	FromHSL(int $H, float $S, float $L):
	static {

		$Output = new static;
		$Output->ImportHSL($H, $S, $L);

		return $Output;
	}

	static public function
	FromRGBA(int $R, int $G, int $B, int $A=255):
	static {

		$Output = new static;
		$Output->ImportRGBA($R, $G, $B, $A);

		return $Output;
	}

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
