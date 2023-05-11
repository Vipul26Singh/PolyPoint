<?php
namespace GeometryControllers;
include_once(__DIR__ . "/../geometry/Helpers.php");
use Geometry\Polygon as Polygon;

class PolygonController {
    private $polygons;
    private $point;
    private $pointInPolygon;

    public function __construct() {
        $this->polygons = array();
    }

    // expects clockwise array of points in format [[x1, y1], [x2, y2], ...]]
    public function addPolygon($name, $coordinateArray) {
        $pol = new Polygon($name);

        $totalPoints = count($coordinateArray); 
		for($i = 0; $i < $totalPoints - 1; $i++) {
			$pol->addCoordinate($coordinateArray[$i][0], $coordinateArray[$i][1]);
		}
        
        if($coordinateArray[$totalPoints-1][0] != $coordinateArray[0][0] && $coordinateArray[$totalPoints-1][1] != $coordinateArray[0][1]) {
            $pol->addCoordinate($coordinateArray[$totalPoints-1][0], $coordinateArray[$totalPoints-1][1]);
        }

        $pol->generate();
        $this->polygons[] = $pol;
    }

    public function isPointInAllPolygons($x, $y) {
        foreach($this->polygons as $pol) {
            if(!$pol->isPointInside($x, $y)) {
                return false;
            }
        }
        return true;
    }

    public function isPointInAnyPolygon($x, $y) {
        foreach($this->polygons as $pol) {
            if($pol->isPointInside($x, $y)) {
                return true;
            }
        }
        return false;
    }

    public function pointInWhichPolygons($x, $y) {
        $namedPolygon = array();
        foreach($this->polygons as $pol) {
            if($pol->isPointInside($x, $y)) {
                $namedPolygon[] = $pol->getName();
            }
        }
        return $namedPolygon;
    }
}
