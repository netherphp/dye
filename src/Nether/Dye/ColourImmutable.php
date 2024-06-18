<?php

namespace Nether\Dye;

class ColourImmutable
extends Colour {

	protected function
	GetReturnTarget():
	static {

		$Output = new static;

		$Output->ImportRGBA(
			$this->RGBA->R,
			$this->RGBA->G,
			$this->RGBA->B,
			$this->RGBA->A
		);

		return $Output;
	}

}
