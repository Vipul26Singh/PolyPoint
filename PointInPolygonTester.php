<?php

include_once(__DIR__ . "/geometry_controllers/PolygonController.php");

use GeometryControllers\PolygonController as PolygonController;

$multiPol = new PolygonController();

#add polygon
$multiPol->addPolygon("First poly", [[-6, 5], [2, 6], [-1, 3], [2, 2], [-4, 1]]);

#add another polygon
$multiPol->addPolygon("Second poly", [[-1, 7], [6, 3], [-2, 0]]);

#test for a point if it is in all polygons
$inAll = $multiPol->isPointInAllPolygons(0, 5) == false ? "false" : "true";
echo "Is (0, 5) in all polygon: " . $inAll . "\n";

$inAll = $multiPol->isPointInAllPolygons(2, 3) == false ? "false" : "true";
echo "Is (2, 3) in all polygon: " . $inAll . "\n";

$inWhich = $multiPol->pointInWhichPolygons(2, 3);
echo "Is (2, 3) in following polygon: \n";
print_r($inWhich);