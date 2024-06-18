<?php ##########################################################################
################################################################################

namespace Nether\Dye\Format;

use Nether\Dye;

################################################################################
################################################################################

class RGBA {

	protected int
	$R = 0;

	protected int
	$B = 0;

	protected int
	$G = 0;

	protected int
	$A = Dye\Util::ByteMax;

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	__Construct(int $R=0, int $G=0, int $B=0, int $A=255) {

		$this->Set($R, $G, $B, $A);

		return;
	}

	public function
	R(?int $R=NULL):
	int {

		if($R !== NULL)
		$this->R = Dye\Util::ClampByte($R);

		return $this->R;
	}

	public function
	G(?int $G=NULL):
	int {

		if($G !== NULL)
		$this->G = Dye\Util::ClampByte($G);

		return $this->G;
	}

	public function
	B(?int $B=NULL):
	int {

		if($B !== NULL)
		$this->B = Dye\Util::ClampByte($B);

		return $this->B;
	}

	public function
	A(int|float|NULL $A=NULL):
	int {

		if(is_float($A))
		$A = (int)round(($A * Dye\Util::ByteMax), 0);

		if($A !== NULL)
		$this->A = Dye\Util::ClampByte($A);

		return $this->A;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	ImportArrayRGBA(array $Bits):
	static {

		match(count($Bits)) {
			3 => $this->Set($Bits[0], $Bits[1], $Bits[2], Dye\Util::ByteMax),
			4 => $this->Set($Bits[0], $Bits[1], $Bits[2], $Bits[3]),
			default => throw new \Exception('expects 3 or 4 inputs')
		};

		return $this;
	}

	public function
	ImportHSL(HSLA $HSL):
	static {

		// none of this was straight forward math. it was written by
		// following with an explained version of the algo.

		$Rot = ($HSL->H / 360.0);
		$RGB = [];
		$T1 = NULL;
		$T2 = NULL;

		////////

		if($HSL->S === 0.0) {
			$this->R = Dye\Util::ClampByte($HSL->L * 255);
			$this->G = $this->R;
			$this->B = $this->R;
			return $this;
		}

		////////

		$T1 = match(TRUE) {
			($HSL->L < 0.5)
			=> $HSL->L * (1.0 + $HSL->S),

			default
			=> ($HSL->L + ($HSL->S - ($HSL->L * $HSL->S)))
		};

		$T2 = (2 * $HSL->L) - $T1;

		////////

		$RGB[0] = $Rot + 0.333;
		$RGB[1] = $Rot;
		$RGB[2] = $Rot - 0.333;

		$RGB = array_map(
			fn(float $V)=> match(TRUE) {
				($V < 0.0) => ($V + 1.0),
				($V > 1.0) => ($V - 1.0),
				default    => $V
			},
			$RGB
		);

		$RGB = array_map(
			fn(float $V)=> match(TRUE) {
				(($V * 6.0) < 1.0)
				=> $T2 + (($T1 - $T2) * 6.0 * $V),

				(($V * 2.0) < 1.0)
				=> $T1,

				(($V * 3.0) < 2.0)
				=> $T2 + (($T1 - $T2) * (0.666 - $V) * 6.0),

				default
				=> $T2
			},
			$RGB
		);

		$RGB = array_map(
			fn(float $V)=> Dye\Util::ClampByte(round((round($V, 2) * 255), 0)),
			$RGB
		);

		////////

		$this->Set(
			$RGB[0], $RGB[1], $RGB[2],
			$HSL->A
		);

		return $this;
	}

	public function
	ImportRGBA(RGBA $RGBA):
	static {

		$this->R = $RGBA->A;
		$this->G = $RGBA->G;
		$this->B = $RGBA->B;
		$this->A = $RGBA->A;

		return $this;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	ToHexRGB():
	string {

		$Output = strtoupper(sprintf(
			'#%02x%02x%02x',
			$this->R,
			$this->G,
			$this->B
		));

		return $Output;
	}

	public function
	ToHexRGBA():
	string {

		$Output = strtoupper(sprintf(
			'#%02x%02x%02x%02x',
			$this->R,
			$this->G,
			$this->B,
			$this->A
		));

		return $Output;
	}

	public function
	ToIntRGB():
	int {

		return (0
			| ($this->R << 16)
			| ($this->G << 8)
			| ($this->B)
		);
	}

	public function
	ToIntRGBA():
	int {

		return (0
			| ($this->R << 24)
			| ($this->G << 16)
			| ($this->B << 8)
			| ($this->A)
		);
	}

	public function
	ToStyleRGB():
	string {

		$Output = sprintf(
			'rgb(%d, %d, %d)',
			$this->R,
			$this->G,
			$this->B
		);

		return $Output;
	}

	public function
	ToStyleRGBA():
	string {

		$Output = sprintf(
			'rgba(%d, %d, %d, %.2f)',
			$this->R, $this->G, $this->B,
			Dye\Util::ClampNormal($this->A / Dye\Util::ByteMax)
		);

		return $Output;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Set(int $R, int $G, int $B, int|float $A):
	static {

		if(is_float($A))
		$A = Dye\Util::ClampByte($A * Dye\Util::ByteMax);

		////////

		$this->R = Dye\Util::ClampByte($R);
		$this->G = Dye\Util::ClampByte($G);
		$this->B = Dye\Util::ClampByte($B);
		$this->A = Dye\Util::ClampByte($A);

		return $this;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	IsBright():
	bool {

		return $this->CalcPercIsBright();
	}

	public function
	IsDark():
	bool {

		return $this->CalcPercIsDark();
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	protected function
	CalcPercBrightness():
	float {

		// implemented from: https://alienryderflex.com/hsp.html

		return sqrt(0
			+ (0.299 * pow($this->R, 2))
			+ (0.587 * pow($this->G, 2))
			+ (0.114 * pow($this->B, 2))
		);
	}

	protected function
	CalcPercIsBright():
	bool {

		// implemented from: https://awik.io/determine-color-bright-dark-using-javascript/

		$PB = $this->CalcPercBrightness();

		return $PB > 127.5;
	}

	protected function
	CalcPercIsDark():
	bool {

		// implemented from: https://awik.io/determine-color-bright-dark-using-javascript/

		$PB = $this->CalcPercBrightness();

		return $PB <= 127.5;
	}

};
