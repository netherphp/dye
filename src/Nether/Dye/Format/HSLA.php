<?php ##########################################################################
################################################################################

namespace Nether\Dye\Format;

use Nether\Dye;

################################################################################
################################################################################

class HSLA {

	public int
	$H;

	public float
	$S;

	public float
	$L;

	public float
	$A;

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	__Construct(int $H=0, float $S=0.0, float $L=0.0, float $A=1.0) {

		$this->H = $H;
		$this->S = $S;
		$this->L = $L;
		$this->A = $A;

		return;
	}

	public function
	H(?int $H=NULL):
	int {

		if($H !== NULL)
		$this->H = Dye\Util::WrapDegrees($H);

		return $this->H;
	}

	public function
	S(?float $S=NULL):
	float {

		if($S !== NULL)
		$this->S = Dye\Util::ClampNormal($S);

		return $this->S;
	}

	public function
	L(?float $L=NULL):
	float {

		if($L !== NULL)
		$this->L = Dye\Util::ClampNormal($L);

		return $this->L;
	}

	public function
	A(?float $A=NULL):
	float {

		if($A !== NULL)
		$this->A = Dye\Util::ClampNormal($A);

		return $this->A;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	ImportRGBA(RGBA $RGBA):
	static {

		$RGBAn = new RGBANormal;
		$RGBAn->ImportRGBA($RGBA);

		return $this->ImportRGBANormal($RGBAn);
	}

	public function
	ImportRGBANormal(RGBANormal $RGBAn):
	static {

		$this->H = $this->CalcHueFromRGBNormal($RGBAn);
		$this->S = $this->CalcSatFromRGBNormal($RGBAn);
		$this->L = $this->CalcLumFromRGBNormal($RGBAn);
		$this->A = $RGBAn->A;

		return $this;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	ToArray(bool $Indexed=TRUE):
	array {

		$Output = [
			'H'=> $this->H,
			'S'=> $this->S,
			'L'=> $this->L,
			'A'=> $this->A
		];

		if(!$Indexed)
		$Output = array_values($Output);

		return $Output;
	}

	public function
	ToStyleHSL():
	string {

		$Output = sprintf(
			'hsl(%d, %.2f, %.2f)',
			$this->H,
			$this->S,
			$this->L
		);

		return $Output;
	}

	public function
	ToStyleHSLA():
	string {

		$Output = sprintf(
			'hsla(%d, %.2f, %.2f, %.2f)',
			$this->H,
			$this->S,
			$this->L,
			$this->A
		);

		return $Output;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Set(int $H, float $S, float $L, float $A):
	static {

		$this->H = Dye\Util::WrapDegrees($H);
		$this->S = Dye\Util::ClampNormal($S);
		$this->L = Dye\Util::ClampNormal($L);
		$this->A = Dye\Util::ClampNormal($A);

		return $this;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	private function
	CalcHueFromRGBNormal(RGBANormal $RGBAn):
	int {

		$Hue = 0;
		$Min = min($RGBAn->R, $RGBAn->G, $RGBAn->B);
		$Max = max($RGBAn->R, $RGBAn->G, $RGBAn->B);
		$Gap = $Max - $Min;

		////////

		$Hue = match(TRUE) {
			($Gap === 0.0)
			=> 0,

			($Max === $RGBAn->R)
			=> 60 * (($RGBAn->G - $RGBAn->B) / $Gap),

			($Max === $RGBAn->G)
			=> 60 * (2.0 + (($RGBAn->B - $RGBAn->R) / $Gap)),

			($Max === $RGBAn->B)
			=> 60 * (4.0 + (($RGBAn->R - $RGBAn->G) / $Gap))
		};

		////////

		return Dye\Util::WrapDegrees($Hue);
	}

	private function
	CalcSatFromRGBNormal(RGBANormal $RGBAn):
	float {

		$Max = max($RGBAn->R, $RGBAn->G, $RGBAn->B);
		$Min = min($RGBAn->R, $RGBAn->G, $RGBAn->B);
		$Lum = $this->CalcLumFromRGBNormal($RGBAn);
		$Sat = 0.0;

		////////

		if($Min === $Max)
		$Sat = 0.0;

		elseif($Lum <= 0.5)
		$Sat = ($Max - $Min) / ($Max + $Min);

		elseif($Lum > 0.5)
		$Sat = ($Max - $Min) / (2.0 - $Max - $Min);

		////////

		return $Sat;
	}

	private function
	CalcLumFromRGBNormal(RGBANormal $RGBAn):
	float {

		$Min = min($RGBAn->R, $RGBAn->G, $RGBAn->B);
		$Max = max($RGBAn->R, $RGBAn->G, $RGBAn->B);
		$Lum = ($Max + $Min) * 0.5;

		return $Lum;
	}

};
