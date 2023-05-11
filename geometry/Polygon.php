<?php
namespace Geometry;
include_once(__DIR__ . "/Helpers.php");

class Polygon {

	private $points = [];
	private $segments = [];
	private $name = "";

	public function __construct($name = "") {
		$this->name = $name;
	}

	//expects in clockwise direction
	public function addCoordinate($x, $y) {
		$p = new Point($x, $y);
		$this->points[] = $p;
	}

	public function getName() {
		return $this->name;
	}

	public function generate() {
		$totalPoints = count($this->points); 
		for($i = 0; $i < $totalPoints - 1; $i++) {
			$seg = new LineSegment($this->points[$i], $this->points[$i+1]);	
			$this->segments[] = $seg;
		}
		$seg = new LineSegment($this->points[$totalPoints - 1], $this->points[0]);
		$this->segments[] = $seg;
	}	


	// returns true if inside polygon, false if outside polygon
	public function isPointInside($x, $y, $onSegement = true) {
		$testPoint = new Point($x, $y);
		debugger("\n\nchecking for point " . $testPoint->__toString());
		$intersectionPoints = array();
		foreach($this->segments as $seg) {
			// need to check if on segement is considered inside or outside
			if($seg->pointOnSegement($testPoint)) {
				debugger("point is on segment");
				return $onSegement;
			}

			$intersect = $seg->intersectionPoint($testPoint);
			
			if($intersect != null && $intersect->isOnRightOf($testPoint)) {
				debugger("Intersection point is " . $intersect->__toString() . " and is on right");
				$intersectionPoints[] = $intersect;
			} else if($intersect != null) {
				debugger("Intersection point is " . $intersect->__toString() . " and is on left");
			} else {
				debugger("Not intersecting");
			}
			
		}
		// filter unqiue points so that if interecting on vertex then 1 point is considered
		$intersectionPoints = array_unique($intersectionPoints);
		// if odd number of intersection points, then inside polygon
		if(count($intersectionPoints) % 2 == 1) {
			return true;
		}
		return false;
	}

}