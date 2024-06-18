<?php ##########################################################################
################################################################################

namespace Nether\Dye\Error;

use Exception;

################################################################################
################################################################################

class InvalidColourFormat
extends Exception {

	public function
	__Construct(mixed $Input, ?string $Info=NULL) {

		$Fmt = match(TRUE) {
			(is_object($Input) || is_array($Input))
			=> json_encode($Input),

			default
			=> $Input
		};

		$More = match(TRUE) {
			($Info !== NULL)
			=> sprintf(' (%s)', $Info),

			default
			=> ''
		};

		parent::__Construct(sprintf(
			'invalid colour format: %s%s',
			$Fmt, $More
		));

		return;
	}

};
