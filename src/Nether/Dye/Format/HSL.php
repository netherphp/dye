<?php ##########################################################################
################################################################################

namespace Nether\Dye\Format;

use Nether\Dye;

################################################################################
################################################################################

class HSL {

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

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Set(int $H, float $S, float $L):
	static {

		$this->H = Dye\Util::WrapDegrees($H);
		$this->S = Dye\Util::ClampNormal($S);
		$this->L = Dye\Util::ClampNormal($L);

		return $this;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	protected function
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

	protected function
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

	protected function
	CalcLumFromRGBNormal(RGBANormal $RGBAn):
	float {

		$Min = min($RGBAn->R, $RGBAn->G, $RGBAn->B);
		$Max = max($RGBAn->R, $RGBAn->G, $RGBAn->B);
		$Lum = ($Max + $Min) * 0.5;

		return $Lum;
	}

};
