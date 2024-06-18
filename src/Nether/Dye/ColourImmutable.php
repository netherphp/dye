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
		$Output->RGB->ImportRGBA($this->RGB);
		$Output->UpdateFromRGB();

		return $Output;
	}

};
