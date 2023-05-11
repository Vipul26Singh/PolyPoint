<?php
namespace Geometry;
include_once(__DIR__ . "/Helpers.php");

class Point {
	private $x, $y;
	public function __construct($x, $y) {
		$this->x = $x;
		$this->y = $y;
	}

	public function getX() {
		return $this->x;
	}

	public function getY() {
		return $this->y;
	}

    public function getVectorRepresentation() {
        return [$this->x, $this->y];
    }

	public function samePoint($p2) {
		if($this->x == $p2->getX() && $this->y == $this->getY()) {
			return true;
		}
		return false;
	}

	public function isOnRightOf($p1) {
		if($this->x >= $p1->getX()) {
			return true;
		}
		return false;
	}

    public function distance($p2) {
        $x1 = $this->x;
        $y1 = $this->y;
        $x2 = $p2->getX();
        $y2 = $p2->getY();
        return sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));
    }

    public function haversineDistance($p2, $unit = 'km') {
        $x1 = $this->x;
        $y1 = $this->y;
        $x2 = $p2->getX(); 
        $y2 = $p2->getY();
        if($x1 == $x2 && $y1 == $y2) {
            return 0;
        }

        $earthRadius = 6371; // km
        $dLat = deg2rad($y2 - $y1);
        $dLon = deg2rad($x2 - $x1);
        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($y1)) * cos(deg2rad($y2)) *
            sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $d = $earthRadius * $c;
        $distanceConvertor = new Distance('km');
        $unit = strtolower($unit);

        return $distanceConvertor->convertTo($unit, $d);
    }

    public function cosineDistance($p2, $unit = 'km') {
        $lon1 = $this->x;
        $lat1 = $this->y;
        $lon2 = $p2->getX(); 
        $lat2 = $p2->getY();

        if(($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $distanceConvertor = new Distance('mi');
        $unit = strtolower($unit);
        return $distanceConvertor->convertTo($unit, $miles);
    }

	public function __toString() {
        return strval($this->x) . "," . strval($this->y);
    }
}