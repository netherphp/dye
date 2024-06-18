<?php ##########################################################################
################################################################################

namespace Nether\Dye\Format;

use Nether\Dye;

################################################################################
################################################################################

class RGBANormal {

	public float
	$R = 0.0;

	public float
	$B = 0.0;

	public float
	$G = 0.0;

	public float
	$A = 1.0;

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	ImportRGBA(RGBA $RGBA):
	static {

		$this->Set(
			$RGBA->R() / Dye\Util::ByteMax,
			$RGBA->G() / Dye\Util::ByteMax,
			$RGBA->B() / Dye\Util::ByteMax,
			$RGBA->A() / Dye\Util::ByteMax
		);

		return $this;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Set(float $R, float $G, float $B, float $A):
	static {

		$this->R = Dye\Util::ClampNormal($R);
		$this->G = Dye\Util::ClampNormal($G);
		$this->B = Dye\Util::ClampNormal($B);
		$this->A = Dye\Util::ClampNormal($A);

		return $this;
	}

};
