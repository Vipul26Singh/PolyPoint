<?php

include_once(__DIR__ . "/geometry_controllers/PolyLineController.php");
use GeometryControllers\PolyLineController as PolyLineController;

$poly = new PolyLineController();

$poly->addPolyLines("1", [[-6, 5], [2, 6], [-1, 3], [2, 2], [-4, 1]]);
$poly->addPolyLines("2", [[0, 0], [3, 2], [1, 1]]);

$out = $poly->getDistanceRatio(-1, 0);
print_r($out);

