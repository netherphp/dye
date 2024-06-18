<?php

namespace Nether\Dye;

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

// methods prefixed Set or Import are currently implied to be exceptions to
// the immutable rule until i hear back from some friends.

class Colour {

	const
	TypeRGB  = 'rgb',
	TypeRGBA = 'rgba',
	TypeHSL  = 'hsl';

	protected Format\RGBA
	$RGBA;

	protected Format\HSL
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
	// QUERY API ///////////////////////////////////////////////////

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
	// MANIPULATION API ////////////////////////////////////////////

	public function
	HueRotate(int $Deg=0):
	static {

		$Out = $this->GetReturnTarget();

		////////

		$Out->HSL->H = Util::WrapDegrees(
			$Out->HSL->H + $Deg
		);

		$Out->UpdateFromHSL();

		return $Out;
	}

	public function
	HueShift(float $Per=0.0):
	static {

		return $this->HueRotate(
			(int)round(($Per * Util::DegMax), 0)
		);
	}

	////////////////////////////////
	////////////////////////////////

	public function
	Saturation(float $Mult=1.0):
	static {

		$Out = $this->GetReturnTarget();

		////////

		$Out->HSL->S = ($Out->HSL->S * $Mult);
		$Out->UpdateFromHSL();

		return $Out;
	}

	public function
	Saturate(float $Str=0.0):
	static {

		$Out = $this->GetReturnTarget();

		////////

		$Out->HSL->S = Util::ClampNormal(
			$Out->HSL->S + ($Out->HSL->S * $Str)
		);

		$Out->UpdateFromHSL();

		return $Out;
	}

	public function
	Desaturate(float $Str=0.0):
	static {

		$Out = $this->GetReturnTarget();

		////////

		$Out->HSL->S = Util::ClampNormal(
			$Out->HSL->S - ($Out->HSL->S * $Str)
		);

		$Out->UpdateFromHSL();

		return $Out;
	}

	////////////////////////////////
	////////////////////////////////

	public function
	Lightness(float $Mult=1.0):
	static {

		$Out = $this->GetReturnTarget();

		////////

		$Out->HSL->L = ($Out->HSL->L * $Mult);
		$Out->UpdateFromHSL();

		return $Out;
	}

	public function
	Lighten(float $Str=0.0):
	static {

		$Out = $this->GetReturnTarget();

		////////

		$Out->HSL->L = Util::ClampNormal(
			$Out->HSL->L + ($Out->HSL->L * $Str)
		);

		$Out->UpdateFromHSL();

		return $Out;
	}

	public function
	Darken(float $Str=0.0):
	static {

		$Out = $this->GetReturnTarget();

		////////

		$Out->HSL->L = Util::ClampNormal(
			$Out->HSL->L - ($Out->HSL->L * $Str)
		);

		$Out->UpdateFromHSL();

		return $Out;
	}

	////////////////////////////////////////////////////////////////
	// COLOUR READING //////////////////////////////////////////////

	public function
	Import(string|int|array|Format\RGBA|Format\HSL $Input, ?string $Type=NULL):
	static {

		if(is_string($Input))
		return $this->DigestString($Input);

		if(is_object($Input))
		return $this->DigestObject($Input);

		////////

		if($Type !== NULL) {
			if(is_array($Input))
			return $this->DigestArray($Input, $Type);

			if(is_int($Input))
			return $this->DigestInteger($Input, $Type);
		}

		////////

		throw new Error\InvalidColourFormat($Input, 'try specific Import* method');

		return $this;
	}

	private function
	DigestObject(Format\RGBA|Format\HSL $Input):
	static {

		match(TRUE) {
			($Input instanceof Format\RGBA)
			=> $this->ImportRGBA($Input->R, $Input->G, $Input->B, $Input->A),

			($Input instanceof Format\HSL)
			=> $this->ImportHSL($Input->H, $Input->S, $Input->L),

			default
			=> new Error\InvalidColourFormat($Input, 'DigestObject')
		};

		return $this;
	}

	private function
	DigestString(string $Input):
	static {

		$In = strtolower(trim($Input));

		////////

		match(TRUE) {
			(str_starts_with($In, '#'))
			=> $this->ImportHexString($In),

			(str_starts_with($In, 'rgb('))
			=> $this->ImportRGBA(...(Util::FetchStyleBits3($In) ?? [ 0, 0, 0 ])),

			(str_starts_with($In, 'rgba('))
			=> $this->ImportRGBA(...(Util::FetchStyleBits4($In) ?? [ 0, 0, 0, 1.0 ])),

			(str_starts_with($In, 'hsl('))
			=> $this->ImportHSL(...(Util::FetchStyleBits3($In) ?? [ 0, 0, 0 ])),

			default
			=> throw new Error\InvalidColourFormat($Input, 'DigestString')
		};

		////////

		return $this;
	}

	private function
	DigestArray(array $Input, string $Type):
	static {

		if(count($Input) === 3) {
			if($Type === static::TypeRGB)
			return $this->ImportRGBA(...$Input);


			if($Type === static::TypeHSL)
			return $this->ImportHSL(...$Input);

		}

		if(count($Input) === 4) {
			if($Type === static::TypeRGBA)
			return $this->ImportRGBA(...$Input);
		}

		////////

		throw new Error\InvalidColourFormat($Input, 'DigestArray');
		return $this;
	}

	private function
	DigestInteger(int $Input, string $Type):
	static {

		if($Type === static::TypeRGB)
		return $this->ImportIntRGB($Input);

		if($Type === static::TypeRGBA)
		return $this->ImportIntRGBA($Input);

		////////

		throw new Error\InvalidColourFormat($Input, 'DigestInteger');
		return $this;
	}

	////////////////////////////////
	////////////////////////////////

	private function
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

	private function
	ImportIntRGB(int $Int):
	static {

		$this->RGBA->ImportArrayRGBA(Util::DecToBitsRGB($Int));
		$this->UpdateFromRGBA();

		return $this;
	}

	private function
	ImportIntRGBA(int $Int):
	static {

		$this->RGBA->ImportArrayRGBA(Util::DecToBitsRGBA($Int));
		$this->UpdateFromRGBA();

		return $this;
	}

	private function
	ImportRGBA(int $R, int $G, int $B, int|float $A=Util::ByteMax):
	static {

		$this->RGBA->Set($R, $G, $B, $A);
		$this->UpdateFromRGBA();

		return $this;
	}

	private function
	ImportHSL(int $H, float $S, float $L):
	static {

		$this->HSL->Set($H, $S, $L);
		$this->RGBA->A = 0xFF;

		$this->UpdateFromHSL();

		return $this;
	}

	////////////////////////////////
	////////////////////////////////

	public function
	SetRGBA(?int $R=NULL, ?int $G=NULL, ?int $B=NULL, int|float|NULL $A=NULL):
	static {

		// this method differs from the import variant in that it allows
		// for the fukken wild wild west over here.

		$this->RGBA->Set(
			$R ?? $this->RGBA->R,
			$G ?? $this->RGBA->G,
			$B ?? $this->RGBA->B,
			$A ?? $this->RGBA->A
		);

		$this->UpdateFromRGBA();

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
		$Output->Import($Input);

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
	FromRGBA(int $R, int $G, int $B, int|float $A=Util::ByteMax):
	static {

		$Output = new static;
		$Output->ImportRGBA($R, $G, $B, $A);

		return $Output;
	}

};
