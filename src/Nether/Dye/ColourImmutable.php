<?php ##########################################################################
################################################################################

namespace Nether\Dye;

################################################################################
################################################################################

class ColourImmutable
extends Colour {

	protected function
	GetReturnTarget():
	static {

		$Output = new static;
		$Output->RGBA->ImportRGBA($this->RGBA);
		$Output->UpdateFromRGBA();

		return $Output;
	}

};
