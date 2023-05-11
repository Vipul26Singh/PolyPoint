<?php
namespace Geometry;
include_once(__DIR__ . "/Helpers.php");

class Line {
	// equation will be saved in the form of ax+by+c = 0
	private $a, $b, $c;
	private $precision;
	public function __construct($p1, $p2 = null) {
		$this->precision = 0.000000000000001;
		if($p2 == null) {
			$this->a = 0;
			$this->b = 1;
			$this->c = -1 * $p1->getY();
		} else {
			$x1 = $p1->getX();
			$y1 = $p1->getY();
			$x2 = $p2->getX();
			$y2 = $p2->getY();

			if($x2 != $x1) {
				$this->a = ($y2 - $y1) / ($x2 - $x1);
				$this->b = -1;
				$this->c = $y1 - ($this->a*$x1);
			} else {
				$this->a = 1;
				$this->b = 0;
				$this->c = -1 * $x1;
			}
		}
	}

	public function isPointOnLine($p) {
		$val = $this->a * $p->getX() + $this->b * $p->getY() + $this->c;
		debugger("Line equation value is: " . $val);
		if($val >=0 && $val < $this->precision) {
			return true;
		}

		return false;
	}

	public function getSlope() {
		if($this->b == 0) {
			return INF;
		} 
		return $this->a / $this->b;
	}

	public function getLineCoefficients() {
		return array($this->a, $this->b, $this->c);
	}

	public function isSameLine($l2) {
		return $this->isParallel($l2) && ($this->getLineCoefficients()[2] == $l2->getLineCoefficients()[2]);
	}

	public function isParallel($l2) {
		$slope1 = $this->getSlope();
		$slope2 = $l2->getSlope();
		
		if((is_infinite($slope1) && is_infinite($slope2)) || ($slope1 == $slope2)) {
			return true;
		}

		return false;
	}

	public function intersectionPoint($l2) {
		$parallel = $this->isParallel($l2);
		$same = $this->isSameLine($l2);
		if($parallel && !$same) {
			return null;
		} else if($same) {
			return INF;
		}
		$x = (($l2->c * $this->b) - ($this->c * $l2->b)) / (($l2->b * $this->a) - ($this->b * $l2->a));
		$y = (($l2->a * $this->c) - ($this->a * $l2->c)) / (($l2->b * $this->a) - ($this->b * $l2->a));
		return new Point($x, $y);
	}

	public function getClosestPoint($p) {
		$x = $p->getX();
		$y = $p->getY();
		$b = $this->b;
		$a = $this->a;
		$c = $this->c;
		$denominator = $a*$a + $b*$b;

		if($denominator == 0) {
			return null;
		}

		// perpendicular cordinates
		$x1 = ($b*($b*$x - $a*$y) - $a*$c) / $denominator;
		$y1 = ($a*(-1*$b*$x + $a*$y) - $b*$c) / $denominator;

		$closestPoint = new Point($x1, $y1);
		return $closestPoint;
	}

	public function __toString() {
		return strval($this->a) . "x + " . strval($this->b) . "y + " . strval($this->c) . " = 0";
	}

}
