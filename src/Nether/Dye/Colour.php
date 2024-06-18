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

	protected function
	GetReturnTarget():
	static {

		return $this;
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

		$Out = $this->GetReturnTarget();

		$Out->HSL->HueRotate($Deg);
		$Out->UpdateFromHSL();

		return $Out;
	}

	public function
	HueShift(float $Per=0.0):
	static {

		return $this->HueRotate((int)round((Util::DegMax * $Per), 0));
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
	Import(mixed $Input):
	static {

		if(is_string($Input))
		return $this->ImportString($Input);

		throw new Error\InvalidColourFormat(
			"{$Input} (try specific Import method)"
		);

		return $this;
	}

	protected function
	ImportString(string $Input):
	static {

		$In = strtolower(trim($Input));

		////////

		match(TRUE) {
			(str_starts_with($In, '#'))
			=> $this->ImportHexString($In),

			(str_starts_with($In, 'rgb('))
			=> $this->ImportRGBA(...Util::FetchStyleBits3($In)),

			(str_starts_with($In, 'rgba('))
			=> $this->ImportRGBA(...Util::FetchStyleBits4($In)),

			(str_starts_with($In, 'hsl('))
			=> $this->ImportHSL(...Util::FetchStyleBits3($In)),

			default
			=> throw new Error\InvalidColourFormat($Input)
		};

		////////

		return $this;
	}

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
	ImportRGBA(int $R, int $G, int $B, int|float $A=Util::ByteMax):
	static {

		if(is_float($A))
		$A = Util::ClampByte($A * Util::ByteMax);

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
			'hsl(%d, %.2f, %.2f)',
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
			'rgb(%d, %d, %d)',
			$this->RGBA->R,
			$this->RGBA->G,
			$this->RGBA->B
		);

		return $Output;
	}

	public function
	ToStyleRGBA():
	string {

		$Output = sprintf(
			'rgba(%d, %d, %d, %.2f)',
			$this->RGBA->R,
			$this->RGBA->G,
			$this->RGBA->B,
			Util::ClampNormal($this->RGBA->A / Util::ByteMax)
		);

		return $Output;
	}

	////////////////////////////////////////////////////////////////
	// FACTORY API /////////////////////////////////////////////////

	static public function
	FromString(string $Input):
	static {

		$Output = new static;
		$Output->ImportString($Input);

		return $Output;
	}

	static public function
	FromHexString(string $RGBa):
	static {

		$Output = new static;
		$Output->ImportHexString($RGBa);

		return $Output;
	}

	static public function
	FromStyleRGB(string $RGB):
	static {

		$Bits = NULL;

		if(!preg_match('/rgb\(([\d]{1,3}), *?([\d]{1,3}), *?([\d]{1,3})\)/i', $RGB, $Bits))
		throw new Error\InvalidColourFormat($RGB);

		////////

		return static::FromRGBA(
			(int)$Bits[1], (int)$Bits[2], (int)$Bits[3]
		);
	}

	static public function
	FromStyleRGBA(string $RGBA):
	static {

		$Bits = NULL;

		if(!preg_match('/rgba\(([\d]+), *?([\d]+), *?([\d]+), *?([\d\.]+)\)/i', $RGBA, $Bits))
		throw new Error\InvalidColourFormat($RGBA);

		////////

		return static::FromRGBA(
			(int)$Bits[1], (int)$Bits[2], (int)$Bits[3],
			Util::ClampByte($Bits[4] * Util::ByteMax)
		);
	}

	static public function
	FromStyleHSL(string $HSL):
	static {

		$Bits = NULL;

		if(!preg_match('/hsl\(([\d]+), *?([\d\.]+), *?([\d\.]+)\)/i', $HSL, $Bits))
		throw new Error\InvalidColourFormat($HSL);

		////////

		return static::FromHSL(
			(int)$Bits[1], (float)$Bits[2], (float)$Bits[3]
		);
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
