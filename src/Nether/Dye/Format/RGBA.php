<?php

namespace Nether\Dye\Format;

################################################################################
################################################################################

use Nether\Dye;

################################################################################
################################################################################

class RGBA {

	public int
	$R = 0;

	public int
	$B = 0;

	public int
	$G = 0;

	public int
	$A = Dye\Colour::ByteMax;

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	ImportArrayRGBA(array $Bits):
	static {

		switch(count($Bits)) {
			case 3:
				$this->Set(
					$Bits[0], $Bits[1], $Bits[2],
					Dye\Colour::ByteMax
				);
				break;

			case 4:
				$this->Set(
					$Bits[0], $Bits[1], $Bits[2],
					$Bits[3]
				);
				break;

			default:
				throw new \Exception('expects 3 or 4 inputs');
				break;
		}

		return $this;
	}

	public function
	ImportHSL(HSL $HSL):
	static {

		$Rot = ($HSL->H / 360.0);
		$RGB = [];
		$T1 = NULL;
		$T2 = NULL;

		////////

		if($HSL->S === 0.0) {
			$this->R = Dye\Colour::ClampByte($HSL->L * 255);
			$this->G = $this->R;
			$this->B = $this->R;
			return $this;
		}

		////////

		$T1 = match(TRUE) {
			($HSL->L < 0.5)
			=> $HSL->L * (1.0 + $HSL->S),

			default
			=> ($HSL->L + ($HSL->S - ($HSL->L * $HSL->S)))
		};

		$T2 = (2 * $HSL->L) - $T1;

		////////

		$RGB[0] = $Rot + 0.333;
		$RGB[1] = $Rot;
		$RGB[2] = $Rot - 0.333;

		$RGB = array_map(
			fn(float $V)=> match(TRUE) {
				($V < 0.0) => ($V + 1.0),
				($V > 1.0) => ($V - 1.0),
				default    => $V
			},
			$RGB
		);

		$RGB = array_map(
			fn(float $V)=> match(TRUE) {
				(($V * 6.0) < 1.0)
				=> $T2 + (($T1 - $T2) * 6.0 * $V),

				(($V * 2.0) < 1.0)
				=> $T1,

				(($V * 3.0) < 2.0)
				=> $T2 + (($T1 - $T2) * (0.666 - $V) * 6.0),

				default
				=> $T2
			},
			$RGB
		);

		$RGB = array_map(
			fn(float $V)=> Dye\Colour::ClampByte(
				round(($V * 255), 0)
			),
			$RGB
		);

		////////

		$this->R = $RGB[0];
		$this->G = $RGB[1];
		$this->B = $RGB[2];
		$this->A = Dye\Colour::ByteMax;

		return $this;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	public function
	Set(int $R, int $G, int $B, int $A):
	static {

		$this->R = Dye\Colour::ClampByte($R);
		$this->G = Dye\Colour::ClampByte($G);
		$this->B = Dye\Colour::ClampByte($B);
		$this->A = Dye\Colour::ClampByte($A);

		return $this;
	}

};
