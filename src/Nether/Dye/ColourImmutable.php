<?php

namespace Nether\Dye;

class ColourImmutable
extends Colour {

	protected function
	GetReturnTarget():
	static {

		return static::FromRGBA(
			$this->RGBA->R,
			$this->RGBA->G,
			$this->RGBA->B,
			$this->RGBA->A
		);
	}

}
