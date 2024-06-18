<?php

namespace Nether\Dye\Error;

use Exception;

class InvalidColourFormat
extends Exception {

	public function
	__Construct(mixed $Input) {

		parent::__Construct(sprintf(
			'invalid colour format: %s',
			$Input
		));

		return;
	}

};
