<?php

require 'vendor/autoload.php';

use TheInnerCircle\Entity\Exception\OutOfParkingSpotsException;
use TheInnerCircle\Entity\ParkingFloor;
use TheInnerCircle\Entity\ParkingGarage;
use TheInnerCircle\Entity\ValueObject\Car;
use TheInnerCircle\Entity\ValueObject\MotorBike;
use TheInnerCircle\Entity\ValueObject\Van;
use TheInnerCircle\Entity\ValueObject\Vehicle;

$garage = new ParkingGarage(floors: [
    // Ground floor for 2 vans
    new ParkingFloor(allowedVehicleTypes: [Van::class], size: 3.0),

    // First floor for 3 cars and 2 bikes
    new ParkingFloor(allowedVehicleTypes: [Car::class, MotorBike::class], size: 4.0),

    // Second floor for 2 bikes
    new ParkingFloor(allowedVehicleTypes: [MotorBike::class], size: 1.0),
]);

foreach ($garage->floors as $index => $floor) {
    $types = array_map(fn ($type) => getVehicleTypeName($type), $floor->allowedVehicleTypes);
    $types = implode(', ', $types);
    echo "Floor $index allows parking for: $types" . " with a total size of {$floor->size}" . PHP_EOL;
}
echo '----' . PHP_EOL;

function tryToPark(ParkingGarage $garage, Vehicle $vehicle)
{

    $type = getVehicleTypeName(get_class($vehicle));
    $availableSpots = $garage->getAvailableParkingSpots($vehicle);

    echo "Trying to park a {$type}, remaining spots for {$type} (before parking): $availableSpots" . PHP_EOL;

    // the try catch here is because normally for performance reasons you don't want to
    // calculate the number of spots first and then park, you want to park and catch the exception
    // to reduce the number of operations. For demonstration purposes we first check if the number of
    // spots available, making this try/catch redundant and could be replaced with a simple if statement
    try {
        $garage->park($vehicle);
        echo "Welcome, please go in";
    } catch (OutOfParkingSpotsException $e) {
        echo "Sorry, no spaces left";
    }

    echo PHP_EOL;
}

/**
 * @param Vehicle $vehicle
 * @return false|string
 */
function getVehicleTypeName(string $type): string|false
{
    $type = explode('\\', $type);
    $type = end($type);
    return $type;
}

// ground floor
tryToPark($garage, new Van());
tryToPark($garage, new Van());
// add a third van to see the "Sorry, no spaces left" message
tryToPark($garage, new Van());

// 1st floor
tryToPark($garage, new Car());
tryToPark($garage, new Car());
tryToPark($garage, new Car());
tryToPark($garage, new MotorBike());
tryToPark($garage, new MotorBike());

// add a 4th car to see the "Sorry, no spaces left" message again
tryToPark($garage, new Car());

// 2nd floor
tryToPark($garage, new MotorBike());
tryToPark($garage, new MotorBike());

// and now also no more bikes are allowed
tryToPark($garage, new MotorBike());
