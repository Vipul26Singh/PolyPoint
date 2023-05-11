<?php
namespace Geometry;
include_once(__DIR__ . "/Helpers.php");

class LineSegment {
	private $p1, $p2, $line;
	public function __construct($p1, $p2) {
		$this->p1 = $p1;
		$this->p2 = $p2;

		$this->line = new Line($p1, $p2);
	}

	public function intersectionPoint($p) {
		debugger("\nChecking for line Segment" . $this->p1->__toString() . " " . $this->p2->__toString());
		debugger("Line equation" . $this->line->__toString());
		$l2 = new Line($p);
		debugger("Point equation" . $l2->__toString());
		$point = $this->line->intersectionPoint($l2);
		
		if(is_numeric($point) && is_infinite($point)) { // coincident lines
			debugger("Conciding line");
			return $p;
		} else if($point == null) { // parallel lines but not coincident
			debugger("Parallel line");
			return null;
		} else if($this->pointOnSegement($point)) {
			debugger("Intersecting on segement");
			return $point;
		}
		debugger("Not intersecting within segment but intersecting at " . $point->__toString());
		return null;
	}

	public function pointOnSegement($p) {
		if(!$this->line->isPointOnLine($p)) {
			return false;
		}

		$x = $p->getX();
		$y = $p->getY();

		$x1 = min($this->p1->getX(), $this->p2->getX());
		$x2 = max($this->p1->getX(), $this->p2->getX());
		$y1 = min($this->p1->getY(), $this->p2->getY());
		$y2 = max($this->p1->getY(), $this->p2->getY());
		
		if($x >= $x1 && $x <= $x2 && $y >= $y1 && $y <= $y2) {
			return true;
		}
		return false;
	}

	public function getClosestPoint($lat, $long) {
		$point = new Point($lat, $long);
		$possiblePoint = $this->line->getClosestPoint($point);
		$distance1 = $this->p1->cosineDistance($point);
		$distance2 = $this->p2->cosineDistance($point);
		$distance3 = $possiblePoint->cosineDistance($point);
		
		// if point is on segment then it is perpendicular to the line
		if($possiblePoint != null && $this->pointOnSegement($possiblePoint)) {
			return $possiblePoint;
		}

		if($distance1 < $distance2 ) {
			return $this->p1;
		} else {
			return $this->p2;
		}
	}

}
