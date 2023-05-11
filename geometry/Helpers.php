<?php
namespace Geometry;
include_once(__DIR__ . "/Line.php");
include_once(__DIR__ . "/Point.php");
include_once(__DIR__ . "/LineSegment.php");
include_once(__DIR__ . "/Polygon.php");


function debugger($msg) {
	$debug = false;
	if($debug) {
		echo  $msg . "\n";
	}
}

class Distance {
	protected $baseUnit;
	protected $child;
	public function __construct($base) {
		$this->baseUnit = $base;
		switch($base) {
			case "km":
				$this->child = new Kilometer();
				break;
			case "m":
				$this->child = new Meter();
				break;
			case "mi":
				$this->child = new Miles();
				break;
			case "nmi":
				$this->child = new NauticalMiles();
				break;
			default:
				throw new Exception("Invalid base unit");
		}
	}

	public function convertTo($toUnit, $value) {
		switch($toUnit) {
			case 'km':
				return $this->child->convertToKilometer($value);
			case 'm':
				return $this->child->convertToMeter($value);
			case 'mi':
				return $this->child->convertToMile($value);
			case 'nmi':
				return $this->child->convertToNauticalMiles($value);
			default:
				throw new Exception("Invalid unit");
		}
	} 
}

class Kilometer {
	public function convertToMile($value) {
		return $value * 0.621371;
	}

	public function convertToMeter($value) {
		return $value * 1000;
	}

	public function convertToNauticalMiles($value) {
		return $value * 0.539957;
	}

	public function convertToKilometer($value) {
		return $value;
	}
}

class Miles {
	public function convertToMile($value) {
		return $value;
	}

	public function convertToMeter($value) {
		return $value * 1609.34;
	}

	public function convertToNauticalMiles($value) {
		return $value * 0.868976;
	}

	public function convertToKilometer($value) {
		return $value * 1.60934;
	}
}

class NauticalMiles{
	public function convertToMile($value) {
		return $value * 1.15078;
	}

	public function convertToMeter($value) {
		return $value * 1852;
	}

	public function convertToNauticalMiles($value) {
		return $value;
	}

	public function convertToKilometer($value) {
		return $value * 1.852;
	}
}

class Meter {
	public function convertToMile($value) {
		return $value * 0.000621371;
	}

	public function convertToMeter($value) {
		return $value;
	}

	public function convertToNauticalMiles($value) {
		return $value * 0.000539957;
	}

	public function convertToKilometer($value) {
		return $value * 0.001;
	}
}

