<?php

namespace Nether\Dye;

class ColourImmutable
extends Colour {

	protected function
	GetReturnTarget():
	static {

		$Output = new static;
		$Output->Import($this->RGBA);

		return $Output;
	}

}
