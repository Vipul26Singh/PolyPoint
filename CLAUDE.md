# CLAUDE.md — PolyPoint

This file provides context for Claude Code when working in this repository.

## Project Overview

**PolyPoint** is a pure PHP geometric computation library. It handles:
- Point-in-polygon testing (ray-casting algorithm)
- Nearest point detection on polylines/coastlines
- Geographic distance calculations (Euclidean, Haversine, Cosine)
- Distance unit conversions (km, miles, nautical miles, meters)
- Multi-polygon and multi-polyline spatial queries

## Tech Stack

- **Language:** PHP 7.0+
- **Dependencies:** None (zero external dependencies)
- **No build system** — plain PHP files, no Composer, no npm

## Directory Structure

```
geometry/               # Core geometry primitives
  Point.php             # x/y point with distance methods
  Line.php              # Line in ax + by + c = 0 form
  LineSegment.php       # Segment with closest-point logic
  Polygon.php           # Polygon with ray-casting containment
  Helpers.php           # Distance unit converter classes

geometry_controllers/   # High-level API layer
  PolygonController.php     # Multi-polygon query controller
  CoastLineController.php   # Coastline/polyline nearest-point controller
  PolyLineController.php    # Distance-ratio between polylines

PointInPolygonTester.php    # Demo script
NearestPointTest.php        # Demo script
NearestPointPercentage.php  # Demo script
```

## Namespaces

- Core classes: `Geometry\` (in `geometry/`)
- Controllers: `GeometryControllers\` (in `geometry_controllers/`)

## Running Code

```bash
php PointInPolygonTester.php
php NearestPointTest.php
php NearestPointPercentage.php
```

No build or install step required.

## Key Design Decisions

- **Ray-casting algorithm** for point-in-polygon (counts rightward ray intersections)
- **Polygon vertices** should be provided in **clockwise order**
- **Haversine formula** is the preferred distance method for lat/lon coordinates
- **Euclidean distance** is used for flat/local coordinate systems
- Floating-point comparisons use **15-decimal precision** (`bccomp` style)
- Controllers wrap arrays of core geometry objects for batch spatial queries

## Common Tasks

### Adding a new distance unit
Edit `geometry/Helpers.php` — add a new class extending the `Distance` base or following the existing `Kilometer`, `Miles`, `NauticalMiles`, `Meter` pattern.

### Adding a new geometric shape
Create a new file in `geometry/` with the appropriate namespace (`namespace Geometry;`). Follow the existing class patterns.

### Adding a new controller
Create a new file in `geometry_controllers/` with `namespace GeometryControllers;`. Controllers typically accept arrays of geometry objects in their constructor.

## Testing

There is no automated test suite. Functionality is validated through the demo scripts in the root directory. When adding features, add a corresponding demo script or extend an existing one.

## Code Style

- PSR-style PHP OOP
- Constructor injection (no static methods in controllers)
- Methods return meaningful objects (e.g., `Point`) rather than raw arrays where possible
