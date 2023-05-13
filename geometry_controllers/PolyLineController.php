<?php
namespace GeometryControllers;
include_once(__DIR__ . "/../geometry/Helpers.php");
include_once(__DIR__ . "/CoastLineController.php");
include_once(__DIR__ . "/PolygonController.php");

use Geometry\Point as Point;
use Geometry\LineSegment as LineSegment;

class PolyLineController {
    private $coastalLines = array();
    private $nearestPoly, $nearestPointInfo;
    private $exceptionList = array();
    private $secondNearestPoly, $secondNearestPointInfo;

    public function addPolyLines($name, $coords) {
        $coast = new CoastLineController($name, $coords);
        $this->coastalLines[] = $coast;
    }

    private function setNearestPolygon($x, $y) {
        $this->nearestPointInfo = array();
        foreach($this->coastalLines as $coasts) {
            $dist = $coasts->nearestPoint($x, $y);

            if( empty($this->nearestPointInfo) || $dist['distance'] < $this->nearestPointInfo['distance']) {
                $this->nearestPointInfo = $dist;
                $this->nearestPoly = $coasts;
            }
        }
    }
    private function setSecondNearestPolygon($x, $y) {
        $this->secondNearestPointInfo = array();
        $this->secondNearestPoly = null;
        foreach($this->coastalLines as $coasts) {
            $dist = $coasts->nearestPoint($x, $y);

            if( !in_array($coasts->getName(), $this->exceptionList) 
                    && ( empty($this->secondNearestPointInfo) || $dist['distance'] < $this->secondNearestPointInfo['distance'])
                ) {
                $this->secondNearestPointInfo = $dist;
                $this->secondNearestPoly = $coasts;
            }
        }
    }

    public function getDistanceRatio($x, $y) {
        $this->setNearestPolygon($x, $y);
        $this->exceptionList[] = $this->nearestPoly->getName();

        while (true) {
            $this->setSecondNearestPolygon($x, $y);

            if(is_null($this->secondNearestPoly)) {
                break;
            }
            
            $this->exceptionList[] = $this->secondNearestPoly->getName();

            $pc = new PolygonController();
            $pc->addPolygon($this->nearestPoly->getName(), $this->nearestPoly->getRawCoordinates());
            $pc->addPolygon($this->secondNearestPoly->getName(), $this->secondNearestPoly->getRawCoordinates());

            if( !$pc->isPointInAllPolygons($x, $y) ) {
                break;
            }
        }

        $nearestPoint = $this->nearestPoly->getName();

        if(is_null($this->secondNearestPoly)) {
            return $nearestPoint;
        }

        $secondNearestPoint = $this->secondNearestPoly->getName();

        $deno = $this->nearestPointInfo['distance'] + $this->secondNearestPointInfo['distance'];
        $num = $this->nearestPointInfo['distance'] < $this->secondNearestPointInfo['distance'] ? $this->nearestPointInfo['distance'] : $this->secondNearestPointInfo['distance'];

        $percent = round(($num * 100) / $deno); 

        if((int)$secondNearestPoint < (int)$nearestPoint) {
            $percent = 100 - $percent;
            $nearestPoint = $secondNearestPoint;
        }

        return ($nearestPoint . "." . $percent);
    }
}
