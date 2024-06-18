<?php ##########################################################################
################################################################################

namespace Nether\Dye;

use Nether\Dye\Format\RGBA;
use Nether\Dye\Format\HSL;

################################################################################
################################################################################

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
	__Construct(string|int|array|RGBA|HSL|NULL $Input=NULL) {

		$this->RGBA = new RGBA;
		$this->HSL = new HSL;

		////////

		if($Input !== NULL)
		$this->Import($Input);

		////////

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

		return $this->RGBA->IsBright();
	}

	public function
	IsDark():
	bool {

		return $this->RGBA->IsDark();
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

	////////////////////////////////
	////////////////////////////////

	public function
	SetRGBA(?int $R=NULL, ?int $G=NULL, ?int $B=NULL, int|float|NULL $A=NULL):
	static {

		$this->RGBA->Set(
			$R ?? $this->RGBA->R,
			$G ?? $this->RGBA->G,
			$B ?? $this->RGBA->B,
			$A ?? $this->RGBA->A
		);

		$this->UpdateFromRGBA();

		return $this;
	}

	public function
	SetHSL(?int $H=NULL, ?float $S=NULL, ?float $L=NULL):
	static {

		$this->HSL->Set(
			$H ?? $this->HSL->H,
			$S ?? $this->HSL->S,
			$L ?? $this->HSL->L
		);

		$this->UpdateFromHSL();

		return $this;
	}

	////////////////////////////////////////////////////////////////
	// FORMAT PRINTING API /////////////////////////////////////////

	public function
	ToHexRGB():
	string {

		return $this->RGBA->ToHexRGB();
	}

	public function
	ToHexRGBA():
	string {

		return $this->RGBA->ToHexRGBA();
	}

	////////////////////////////////
	////////////////////////////////

	public function
	ToIntRGB():
	int {

		return $this->RGBA->ToIntRGB();
	}

	public function
	ToIntRGBA():
	int {

		return $this->RGBA->ToIntRGBA();
	}

	////////////////////////////////
	////////////////////////////////

	public function
	ToStyleHSL():
	string {

		return $this->HSL->ToStyleHSL();
	}

	public function
	ToStyleRGB():
	string {

		return $this->RGBA->ToStyleRGB();
	}

	public function
	ToStyleRGBA():
	string {

		return $this->RGBA->ToStyleRGBA();
	}

	////////////////////////////////////////////////////////////////
	// COLOUR READING //////////////////////////////////////////////

	public function
	Import(string|int|array|Format\RGBA|Format\HSL $Input, ?string $Type=NULL):
	static {

		if(is_string($Input))
		return $this->ImportDigestString($Input);

		if(is_object($Input))
		return $this->ImportDigestObject($Input);

		////////

		if($Type !== NULL) {
			if(is_array($Input))
			return $this->ImportDigestArray($Input, $Type);

			if(is_int($Input))
			return $this->ImportDigestInteger($Input, $Type);
		}

		////////

		throw new Error\InvalidColourFormat($Input, 'try specific Import* method');

		return $this;
	}

	private function
	ImportDigestObject(Format\RGBA|Format\HSL $Input):
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
	ImportDigestString(string $Input):
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
			=> throw new Error\InvalidColourFormat($Input, 'DigestString')
		};

		////////

		return $this;
	}

	private function
	ImportDigestArray(array $Input, string $Type):
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
	ImportDigestInteger(int $Input, string $Type):
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
