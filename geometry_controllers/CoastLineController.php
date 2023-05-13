<?php
namespace GeometryControllers;
include_once(__DIR__ . "/../geometry/Helpers.php");
use Geometry\Point as Point;
use Geometry\LineSegment as LineSegment;

class CoastLineController {
    private $points = array();
    private $name = "";
    private $rawCordinates = "";

    public function __construct($name, $coordinateArray) {
        $this->points = array();
        $this->rawCordinates = $coordinateArray;
        $this->name = $name;
        $totalPoints = count($coordinateArray); 
		for($i = 0; $i < $totalPoints; $i++) {
            $point = new Point($coordinateArray[$i][1], $coordinateArray[$i][0]); // x
			$this->points[] = $point;
		}
    }

    public function getRawCoordinates() {
        return $this->rawCordinates;
    }
    public function nearestPointIndexInArray($lat, $long) {
        $searchPoint = new Point($long, $lat);
        $totalPoints = count($this->points);
        $minIndex = 0;
        $minDistance = 0;
        for($i = 0; $i < $totalPoints; $i++) {
            $distance = $searchPoint->cosineDistance($this->points[$i]);
            if($i == 0 || $distance < $minDistance) {
                $minDistance = $distance;
                $minIndex = $i;
            }
        }
        return $minIndex;
    }

    public function nearestPoint($lat, $long, $unit = 'km') {
        $index = $this->nearestPointIndexInArray($lat, $long);
        $point = $this->points[$index];
        $targetPoint = new Point($long, $lat);
        $distance = $point->cosineDistance($targetPoint);


        $point1 = 0;
        if($index > 0 ) {
            $previous = $this->points[$index - 1];
            $lineSegment = new LineSegment($previous, $point);
            $point1 = $lineSegment->getClosestPoint($lat, $long);

            if($point1->cosineDistance($targetPoint) < $distance) {
                $point = $point1;
                $distance = $point1->cosineDistance($targetPoint);
            }
        }

        $point2 = 0;
        if($index < count($this->points) - 1) {
            $next = $this->points[$index + 1];
            // find with next point
            $lineSegment = new LineSegment($point, $next);
            $point2 = $lineSegment->getClosestPoint($lat, $long);

            if($point2->cosineDistance($targetPoint) < $distance) {
                $point = $point2;
                $distance = $point2->cosineDistance($targetPoint);
            }
        }

        $distance = $point->cosineDistance($targetPoint, $unit);
        return array("point" => $point, "distance" => $distance, "name" => $this->name);
    }

    public function getName() {
        return $this->name;
    }

}
