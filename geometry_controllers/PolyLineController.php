<?php
namespace GeometryControllers;
include_once(__DIR__ . "/../geometry/Helpers.php");
include_once(__DIR__ . "/CoastLineController.php");

use Geometry\Point as Point;
use Geometry\LineSegment as LineSegment;

class PolyLineController {
    private $coastalLines = array();
    private $nearestPoly, $nearestDistance;
    private $secondNearestPoly, $secondNearestDistance;

    public function addPolyLines($name, $coords) {
        $coast = new CoastLineController($name, $coords);
        $this->coastalLines[] = $coast;
    }

    private function setNearestPolygon($x, $y) {
        $this->nearestDistance = -1;
        foreach($this->coastalLines as $coasts) {
            $dist = $coasts->nearestPoint($x, $y);
            $dist = $dist['distance'];

            if($this->nearestDistance == -1 || $dist < $this->nearestDistance) {
                $this->nearestDistance = $dist;
                $this->nearestPoly = $coasts->getName();
            }
        }
    }
    private function setSecondNearestPolygon($x, $y) {
        $this->setNearestPolygon($x, $y);
        $this->secondNearestDistance = -1;
        foreach($this->coastalLines as $coasts) {
            $dist = $coasts->nearestPoint($x, $y);
            $dist = $dist['distance'];

            if($coasts->getName() != $this->nearestPoly 
                    && ($this->secondNearestDistance == -1 || $dist < $this->secondNearestDistance)
                ) {
                $this->secondNearestDistance = $dist;
                $this->secondNearestPoly = $coasts->getName();
            }
        }
    }

    public function getDistanceRatio($x, $y) {
        $this->setSecondNearestPolygon($x, $y);
        $nearestPoint = $this->nearestPoly;
        $deno = $this->nearestDistance + $this->secondNearestDistance;
        $num = $this->nearestDistance < $this->secondNearestDistance ? $this->nearestDistance : $this->secondNearestDistance;

        $percent = round(($num * 100) / $deno); 

        return ($nearestPoint . "." . $percent);
    }



}
