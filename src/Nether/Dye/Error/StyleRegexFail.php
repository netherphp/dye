<?php

namespace Nether\Dye\Error;

use Exception;

class StyleRegexFail
extends Exception {

	public function
	__Construct(string $Input) {

		$Message = "my regex failed to understand crazy: {$Input}";
		parent::__Construct($Message);

		return;
	}

};
