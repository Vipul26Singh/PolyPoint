# PolyPoint — PHP Geometric Computation Library

**PolyPoint** is a lightweight, zero-dependency PHP library for geometric computations including **point-in-polygon testing**, **nearest point detection on polylines**, and **geographic distance calculations** using Haversine and Great Circle formulas.

---

## Features

- **Point-in-Polygon Testing** — Determine if a coordinate lies inside one or more polygons using the ray-casting algorithm
- **Nearest Point on Polyline** — Find the closest point on a coastline or polyline to a given coordinate
- **Geographic Distance Calculations** — Supports Euclidean, Haversine, and Cosine (Great Circle) distance formulas
- **Multiple Distance Units** — Kilometers, miles, nautical miles, and meters with automatic unit conversion
- **Multi-Polygon & Multi-Polyline Support** — Query against sets of polygons or polylines in a single call
- **Distance Ratio Between Polylines** — Calculate the proportional distance of a point between two parallel polylines
- **Pure PHP** — No external dependencies, no Composer required

---

## Installation

Clone the repository directly into your project:

```bash
git clone https://github.com/vipul26singh/polypoint.git
```

Include the files you need using PHP's `require_once`:

```php
require_once 'polypoint/geometry/Point.php';
require_once 'polypoint/geometry/Polygon.php';
require_once 'polypoint/geometry_controllers/PolygonController.php';
```

No package manager or build step required.

---

## Quick Start

### Point-in-Polygon

```php
use Geometry\Point;
use Geometry\Polygon;
use GeometryControllers\PolygonController;

// Define polygon vertices (clockwise order)
$polygonPoints = [
    new Point(0, 0),
    new Point(10, 0),
    new Point(10, 10),
    new Point(0, 10),
];

$polygon = new Polygon($polygonPoints);
$controller = new PolygonController([$polygon]);

$testPoint = new Point(5, 5);

if ($controller->isPointInAnyPolygon($testPoint)) {
    echo "Point is inside the polygon.";
}
```

### Nearest Point on a Coastline

```php
use Geometry\Point;
use GeometryControllers\CoastLineController;

$coastlinePoints = [
    new Point(0.0, 0.0),
    new Point(1.0, 0.5),
    new Point(2.0, 1.0),
];

$controller = new CoastLineController([$coastlinePoints]);

$myLocation = new Point(1.0, 1.5);
$nearest = $controller->getNearestPoint($myLocation);

echo "Nearest point: ({$nearest->x}, {$nearest->y})";
```

### Distance Calculation

```php
use Geometry\Point;

$pointA = new Point(48.8566, 2.3522);   // Paris
$pointB = new Point(51.5074, -0.1278);  // London

// Haversine distance in kilometers
$distanceKm = $pointA->haversineDistance($pointB);
echo "Distance: {$distanceKm} km";
```

---

## API Reference

### `Geometry\Point`

| Method | Description |
|---|---|
| `__construct(float $x, float $y)` | Create a point with x/y (or lat/lon) coordinates |
| `euclideanDistance(Point $other)` | Euclidean straight-line distance |
| `haversineDistance(Point $other)` | Geographic distance using the Haversine formula |
| `cosineDistance(Point $other)` | Geographic distance using the Spherical Law of Cosines |

### `Geometry\Polygon`

| Method | Description |
|---|---|
| `__construct(array $points)` | Create a polygon from an array of `Point` objects |
| `containsPoint(Point $point)` | Returns `true` if the point lies inside the polygon |

### `GeometryControllers\PolygonController`

| Method | Description |
|---|---|
| `__construct(array $polygons)` | Accepts an array of `Polygon` objects |
| `isPointInAnyPolygon(Point $point)` | Returns `true` if point is in at least one polygon |
| `isPointInAllPolygons(Point $point)` | Returns `true` if point is in every polygon |
| `getContainingPolygons(Point $point)` | Returns array of polygons that contain the point |

### `GeometryControllers\CoastLineController`

| Method | Description |
|---|---|
| `__construct(array $polylines)` | Accepts an array of polylines (each is an array of `Point`) |
| `getNearestPoint(Point $point)` | Returns the nearest `Point` on any polyline |
| `getNearestPointWithDistance(Point $point)` | Returns nearest point with calculated distance |

### `GeometryControllers\PolyLineController`

| Method | Description |
|---|---|
| `__construct(array $polylines)` | Accepts an array of polylines |
| `getDistanceRatio(Point $point)` | Returns proportional distance of a point between two polylines (0.0–1.0) |

### `Geometry\Helpers` — Distance Units

```php
use Geometry\Kilometer;
use Geometry\Miles;
use Geometry\NauticalMiles;
use Geometry\Meter;

$km = new Kilometer(100);
echo $km->toMiles();         // Convert to miles
echo $km->toNauticalMiles(); // Convert to nautical miles
echo $km->toMeters();        // Convert to meters
```

---

## Distance Algorithms

| Algorithm | Best For |
|---|---|
| **Euclidean** | Flat/local coordinate systems |
| **Haversine** | Geographic lat/lon, accurate up to antipodal distances |
| **Cosine (Great Circle)** | Geographic lat/lon, simpler formula for short distances |

---

## Project Structure

```
PolyPoint/
├── geometry/
│   ├── Point.php              # Point class with distance methods
│   ├── Line.php               # Line equation (ax + by + c = 0)
│   ├── LineSegment.php        # Line segment with closest-point logic
│   ├── Polygon.php            # Polygon with ray-casting containment test
│   └── Helpers.php            # Distance unit converters
│
├── geometry_controllers/
│   ├── PolygonController.php  # Multi-polygon query API
│   ├── CoastLineController.php # Polyline nearest-point API
│   └── PolyLineController.php  # Polyline distance-ratio API
│
├── PointInPolygonTester.php   # Demo: point-in-polygon
├── NearestPointTest.php       # Demo: nearest point on coastline
└── NearestPointPercentage.php # Demo: distance ratio between polylines
```

---

## Running the Demo Scripts

```bash
# Test point-in-polygon
php PointInPolygonTester.php

# Test nearest point on a coastline
php NearestPointTest.php

# Test distance ratio between polylines
php NearestPointPercentage.php
```

---

## Use Cases

- **GIS Applications** — Region containment checks for mapping tools
- **Marine Navigation** — Nearest coastline point and nautical distance calculations
- **Geofencing** — Detect when a GPS coordinate enters or exits a defined zone
- **Logistics** — Route proximity and boundary analysis
- **Location-Based Services** — Distance queries for coordinates in PHP backends

---

## Requirements

- PHP 7.0 or higher
- No external dependencies

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/your-feature`)
3. Commit your changes (`git commit -m 'Add your feature'`)
4. Push to the branch (`git push origin feature/your-feature`)
5. Open a Pull Request

---

## Author

**Vipul Singh** — [github.com/vipul26singh](https://github.com/vipul26singh)

---

*PolyPoint — Fast, dependency-free geometric computations in PHP.*
