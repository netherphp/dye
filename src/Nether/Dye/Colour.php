<?php

namespace Nether\Dye;

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

class Colour {

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

	public function
	IsBright():
	bool {

		return $this->RGBA->CalcPercIsBright();
	}

	public function
	IsDark():
	bool {

		return $this->RGBA->CalcPercIsDark();
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	HueRotate(int $Deg=0):
	static {

		$this->HSL->H = Util::WrapDegrees(
			$this->HSL->H + $Deg
		);

		$this->UpdateFromHSL();

		return $this;
	}

	public function
	HueShift(float $Per=0.0):
	static {

		$this->HueRotate(
			(int)round((Util::DegMax * $Per), 0)
		);

		$this->UpdateFromHSL();

		return $this;
	}

	public function
	Saturate(float $Per=0.0):
	static {

		$this->HSL->S = Util::ClampNormal(
			$this->HSL->S + ($this->HSL->S * $Per)
		);

		$this->UpdateFromHSL();

		return $this;
	}

	public function
	Desaturate(float $Per=0.0):
	static {

		$this->HSL->S = Util::ClampNormal(
			$this->HSL->S - ($this->HSL->S * $Per)
		);

		$this->UpdateFromHSL();

		return $this;
	}

	public function
	Lighten(float $Per=0.0):
	static {

		$this->HSL->L = Util::ClampNormal(
			$this->HSL->L + ($this->HSL->L * $Per)
		);

		$this->UpdateFromHSL();

		return $this;
	}

	public function
	Darken(float $Per=0.0):
	static {

		$this->HSL->L = Util::ClampNormal(
			$this->HSL->L - ($this->HSL->L * $Per)
		);

		$this->UpdateFromHSL();

		return $this;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Saturation(float $Mult=1.0):
	static {

		$this->HSL->S = ($this->HSL->S * $Mult);
		$this->UpdateFromHSL();

		return $this;
	}

	public function
	Lightness(float $Mult=1.0):
	static {

		$this->HSL->L = ($this->HSL->L * $Mult);
		$this->UpdateFromHSL();

		return $this;
	}

	////////////////////////////////////////////////////////////////
	// COLOUR READING //////////////////////////////////////////////

	public function
	ImportHexString(string $Hex):
	static {

		$Hex = ltrim($Hex, '#');
		$Len = strlen($Hex);

		if(preg_match('/[^0-9a-fA-F]/', $Hex))
		throw new \Exception('invalid hex string');

		////////

		$this->RGBA->ImportArrayRGBA(match(TRUE) {
			($Len === 8) => Util::DecToBitsRGBA(hexdec($Hex)),
			($Len === 6) => [ ...Util::DecToBitsRGB(hexdec($Hex)), 0xFF ],
			($Len === 4) => Util::ShortToBitsRGBA(hexdec($Hex)),
			($Len === 3) => [ ...Util::ShortToBitsRGB(hexdec($Hex)), 0xFF ],
			default      => throw new \Exception('invalid hex colour format')
		});

		////////

		$this->UpdateFromRGBA();

		return $this;
	}

	public function
	ImportIntRGB(int $Int):
	static {

		$this->RGBA->ImportArrayRGBA(Util::DecToBitsRGB($Int));
		$this->UpdateFromRGBA();

		return $this;
	}

	public function
	ImportIntRGBA(int $Int):
	static {

		$this->RGBA->ImportArrayRGBA(Util::DecToBitsRGBA($Int));
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

	public function
	ToStyleHSL():
	string {

		$Output = sprintf(
			'hsl(%d, %.4f, %.4f)',
			$this->HSL->H,
			$this->HSL->S,
			$this->HSL->L
		);

		return $Output;
	}

	public function
	ToStyleRGB():
	string {

		$Output = sprintf(
			'hsl(%d, %d, %d)',
			$this->RGBA->R,
			$this->RGBA->G,
			$this->RGBA->B
		);

		return $Output;
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

};
