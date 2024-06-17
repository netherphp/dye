<?php

namespace Nether\Dye\Format;

################################################################################
################################################################################

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

		$this->R = $RGBA->R / Dye\Colour::ByteMax;
		$this->G = $RGBA->G / Dye\Colour::ByteMax;
		$this->B = $RGBA->B / Dye\Colour::ByteMax;
		$this->A = $RGBA->A / Dye\Colour::ByteMax;

		return $this;
	}

};
