<?php

require_once 'ParkingGarage.php';


// Example usage:
$floorData = [
    ['id' => 1, 'name' => 'First Floor', 'capacity' => 3],
    ['id' => 2, 'name' => 'Second Floor', 'capacity' => 4],
    ['id' => 0, 'name' => 'Ground Floor', 'capacity' => 5]
];

$garage = new ParkingGarage($floorData);

// Create vehicles
$car = new Car();
$motorcycle = new Motorcycle();
$van = new Van();

// Attempt to park vehicles
echo $garage->parkVehicle($car) . "\n";
echo $garage->parkVehicle($motorcycle) . "\n";
echo $garage->parkVehicle($van) . "\n";
echo $garage->parkVehicle($car) . "\n";
echo $garage->parkVehicle($motorcycle) . "\n";
echo $garage->parkVehicle($van) . "\n";
echo $garage->parkVehicle($car) . "\n";
echo $garage->parkVehicle($motorcycle) . "\n";
echo $garage->parkVehicle($van) . "\n";
echo $garage->parkVehicle($car) . "\n";
echo $garage->parkVehicle($motorcycle) . "\n";
echo $garage->parkVehicle($van) . "\n";
echo $garage->parkVehicle($car) . "\n";
echo $garage->parkVehicle($motorcycle) . "\n";

// Optionally display info about floors
echo 'Spaces left on each floor:' . "\n";
foreach ($garage->floors as $floor) {
    echo $floor . "\n";
}