<?php

include_once(__DIR__ . "/geometry_controllers/CoastLineController.php");
use GeometryControllers\CoastLineController as CoastLineController;

$coastLine1 = new CoastLineController("Front Beach", [[-6, 5], [2, 6], [-1, 3], [2, 2], [-4, 1]]);

$nearestPointDetails = $coastLine1->nearestPoint(0, 0);
$nearestPointMi = $coastLine1->nearestPoint(0, 0, "mi");
$nearestPointNMi = $coastLine1->nearestPoint(0, 0, "nmi");

echo "Coast line is " . $nearestPointDetails['name'] . "\n";
echo "Distance in km is " . $nearestPointDetails['distance'] . "\n";
echo "Distance in mi is " . $nearestPointMi['distance'] . "\n";
echo "Distance in nautical mi is " . $nearestPointNMi['distance'] . "\n";
echo "Point is: ";
print_r($nearestPointDetails['point']->getVectorRepresentation());


$coastLine2 = new CoastLineController("Back Beach", [[0, 0], [3, 2], [1, 1]]);

$nearestPointDetails = $coastLine2->nearestPoint(1, 1, "km");
$nearestPointMi = $coastLine2->nearestPoint(1, 1, "mi");

echo "Coast line is " . $nearestPointDetails['name'] . "\n";
echo "Distance in km is " . $nearestPointDetails['distance'] . "\n";
echo "Distance in mi is " . $nearestPointMi['distance'] . "\n";
echo "Point is: ";
print_r($nearestPointDetails['point']->getVectorRepresentation());


$coastLine3 = new CoastLineController("Temp Back Beach", [[32.9697, -96.80322]]);

$nearestPointDetails = $coastLine3->nearestPoint(29.46786, -98.53506, "km");
$nearestPointMi = $coastLine3->nearestPoint(29.46786, -98.53506, "mi");
$nearestPointNMi = $coastLine3->nearestPoint(29.46786, -98.53506, "nmi");

echo "Coast line is " . $nearestPointDetails['name'] . "\n";
echo "Distance in km is " . $nearestPointDetails['distance'] . "\n";
echo "Distance in mi is " . $nearestPointMi['distance'] . "\n";
echo "Distance in nautical mi is " . $nearestPointNMi['distance'] . "\n";
echo "Point is: ";
print_r($nearestPointDetails['point']->getVectorRepresentation());