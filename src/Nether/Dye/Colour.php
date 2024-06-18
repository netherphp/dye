<?php ##########################################################################
################################################################################

namespace Nether\Dye;

use Nether\Dye\Format\RGBA;
use Nether\Dye\Format\HSLA;

################################################################################
################################################################################

class Colour {

	const
	TypeRGB  = 'rgb',
	TypeRGBA = 'rgba',
	TypeHSL  = 'hsl';

	public Format\RGBA
	$RGB;

	public Format\HSLA
	$HSL;

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	__Construct(string|RGBA|HSLA|NULL $Input=NULL) {

		$this->RGB = new RGBA;
		$this->HSL = new HSLA;

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
	IsBright():
	bool {

		return $this->RGB->IsBright();
	}

	public function
	IsDark():
	bool {

		return $this->RGB->IsDark();
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
	Mix(self $With, float $Str=0.5):
	static {

		$Src = $this->RGB->ToArray();
		$Dst = $With->RGB->ToArray();
		$New = [];
		$Out = NULL;
		$K = NULL;
		$V = NULL;
		$D = NULL;

		foreach($Src as $K => $V) {
			$Diff = ($Src[$K] - $Dst[$K]) * $Str;

			$New[$K] = match(TRUE) {
				($Diff < 0)
				=> $Src[$K] + abs($Diff),

				($Diff > 0)
				=> $Src[$K] - abs($Diff),

				default
				=> $Src[$K]
			};

			$New[$K] = (int)$New[$K];
			continue;
		}

		$Out = $this->SetRGB(...$New);

		return $Out;
	}

	////////////////////////////////
	////////////////////////////////

	public function
	SetRGB(?int $R=NULL, ?int $G=NULL, ?int $B=NULL, int|float|NULL $A=NULL):
	static {

		$Out = $this->GetReturnTarget();

		$Out->RGB->Set(
			$R ?? $Out->RGB->R(),
			$G ?? $Out->RGB->G(),
			$B ?? $Out->RGB->B(),
			$A ?? $Out->RGB->A()
		);

		$Out->UpdateFromRGBA();

		return $Out;
	}

	public function
	SetHSL(?int $H=NULL, ?float $S=NULL, ?float $L=NULL, ?float $A=NULL):
	static {

		$Out = $this->GetReturnTarget();

		$Out->HSL->Set(
			$H ?? $Out->HSL->H,
			$S ?? $Out->HSL->S,
			$L ?? $Out->HSL->L,
			$A ?? $Out->HSL->A
		);

		$Out->UpdateFromHSL();

		return $Out;
	}

	////////////////////////////////////////////////////////////////
	// FORMAT PRINTING API /////////////////////////////////////////

	public function
	ToHexRGB():
	string {

		return $this->RGB->ToHexRGB();
	}

	public function
	ToHexRGBA():
	string {

		return $this->RGB->ToHexRGBA();
	}

	////////////////////////////////
	////////////////////////////////

	public function
	ToIntRGB():
	int {

		return $this->RGB->ToIntRGB();
	}

	public function
	ToIntRGBA():
	int {

		return $this->RGB->ToIntRGBA();
	}

	////////////////////////////////
	////////////////////////////////

	public function
	ToStyleHSL():
	string {

		return $this->HSL->ToStyleHSL();
	}

	public function
	ToStyleHSLA():
	string {

		return $this->HSL->ToStyleHSLA();
	}

	public function
	ToStyleRGB():
	string {

		return $this->RGB->ToStyleRGB();
	}

	public function
	ToStyleRGBA():
	string {

		return $this->RGB->ToStyleRGBA();
	}

	////////////////////////////////////////////////////////////////
	// COLOUR READING //////////////////////////////////////////////

	public function
	Import(string|int|array|RGBA|HSLA $Input, ?string $Type=NULL):
	?static {

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
		return NULL;
	}

	private function
	ImportDigestObject(RGBA|HSLA $Input):
	static {

		$Out = match(TRUE) {
			($Input instanceof RGBA)
			=> $this->ImportRGBA($Input->R(), $Input->G(), $Input->B(), $Input->A()),

			($Input instanceof HSLA)
			=> $this->ImportHSL($Input->H, $Input->S, $Input->L),

			default
			=> new Error\InvalidColourFormat($Input, 'DigestObject')
		};

		return $Out;
	}

	private function
	ImportDigestString(string $Input):
	static {

		$In = strtolower(trim($Input));

		////////

		$Out = match(TRUE) {
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

		return $Out;
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

		$Out = $this->GetReturnTarget();
		$Hex = ltrim($Hex, '#');
		$Len = strlen($Hex);

		if(preg_match('/[^0-9a-fA-F]/', $Hex))
		throw new \Exception('invalid hex string');

		////////

		$Out->RGB->ImportArrayRGBA(match(TRUE) {
			($Len === 8) => Util::DecToBitsRGBA(hexdec($Hex)),
			($Len === 6) => [ ...Util::DecToBitsRGB(hexdec($Hex)), 0xFF ],
			($Len === 4) => Util::ShortToBitsRGBA(hexdec($Hex)),
			($Len === 3) => [ ...Util::ShortToBitsRGB(hexdec($Hex)), 0xFF ],
			default      => throw new \Exception('invalid hex colour format')
		});

		////////

		$Out->UpdateFromRGBA();

		return $Out;
	}

	private function
	ImportIntRGB(int $Int):
	static {

		$Out = $this->GetReturnTarget();

		$Out->RGB->ImportArrayRGBA(Util::DecToBitsRGB($Int));
		$Out->UpdateFromRGBA();

		return $Out;
	}

	private function
	ImportIntRGBA(int $Int):
	static {

		$Out = $this->GetReturnTarget();

		$Out->RGB->ImportArrayRGBA(Util::DecToBitsRGBA($Int));
		$Out->UpdateFromRGBA();

		return $Out;
	}

	private function
	ImportRGBA(int $R, int $G, int $B, int|float $A=Util::ByteMax):
	static {

		$Out = $this->GetReturnTarget();

		$Out->RGB->Set($R, $G, $B, $A);
		$Out->UpdateFromRGBA();

		return $Out;
	}

	private function
	ImportHSL(int $H, float $S, float $L, float $A=1.0):
	static {

		$Out = $this->GetReturnTarget();

		$Out->HSL->Set($H, $S, $L, $A);
		$Out->RGB->A(0xFF);

		$Out->UpdateFromHSL();

		return $Out;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	protected function
	UpdateFromRGBA():
	static {

		$this->HSL->ImportRGBA($this->RGB);

		return $this;
	}

	protected function
	UpdateFromHSL():
	static {

		$this->RGB->ImportHSL($this->HSL);

		return $this;
	}

	////////////////////////////////////////////////////////////////
	// FACTORY API /////////////////////////////////////////////////

	static public function
	From(string|RGBA|HSLA $Input):
	static {

		$Output = new static;
		$Output = $Output->Import($Input);

		return $Output;
	}

	static public function
	FromIntRGB(int $RGB):
	static {

		$Output = new static;
		$Output = $Output->ImportIntRGB($RGB);

		return $Output;
	}

	static public function
	FromIntRGBA(int $RGBA):
	static {

		$Output = new static;
		$Output = $Output->ImportIntRGBA($RGBA);

		return $Output;
	}

	static public function
	FromHSL(int $H, float $S, float $L, float $A=1.0):
	static {

		$Output = new static;
		$Output = $Output->ImportHSL($H, $S, $L, $A);

		return $Output;
	}

	static public function
	FromRGB(int $R, int $G, int $B, int|float $A=Util::ByteMax):
	static {

		$Output = new static;
		$Output = $Output->ImportRGBA($R, $G, $B, $A);

		return $Output;
	}

};
