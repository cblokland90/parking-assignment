<?php

abstract class Vehicle {
    protected $size;

    public function getSize() {
        return $this->size;
    }
}

class Car extends Vehicle {
    public function __construct() {
        $this->size = 1.0;
    }
}

class Motorcycle extends Vehicle {
    public function __construct() {
        $this->size = 0.5;
    }
}

class Van extends Vehicle {
    public function __construct() {
        $this->size = 1.5;
    }
}

class ParkingFloor {
    private $id;
    private $name;
    private $capacity;
    private $occupied;

    public function __construct($id, $name, $capacity) {
        $this->id = $id;
        $this->name = $name;
        $this->capacity = $capacity;
        $this->occupied = 0;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function canPark($vehicleSize) {
        return ($this->occupied + $vehicleSize) <= $this->capacity;
    }

    public function park($vehicleSize) {
        $this->occupied += $vehicleSize;
    }

    public function getFreeSpaces() {
        return $this->capacity - $this->occupied;
    }

    public function __toString() {
        return "Floor {$this->name} (ID: {$this->id}), Capacity: {$this->capacity}, Free Spaces: " . $this->getFreeSpaces();
    }
}

/**
 * The `ParkingGarage` class represents a parking garage with multiple floors.
 */
class ParkingGarage {
    public $floors;

    /**
     * @param $floorData
     */
    public function __construct($floorData) {
        $this->floors = [];
        foreach ($floorData as $data) {
            $this->floors[$data['id']] = new ParkingFloor($data['id'], $data['name'], $data['capacity']);
        }
    }

    /**
     * - The `parkVehicle` method checks each floor for available space and parks the vehicle if possible:
     * - Vans (`Van`) are only allowed to park on the ground floor
     * @param $vehicle
     * @return string
     */
    public function parkVehicle($vehicle) {
        $vehicleSize = $vehicle->getSize();

        foreach ($this->floors as $floor) {
            if ($vehicle instanceof Van && $floor->getId() !== 0) {
                continue; // Vans can only park on the ground floor (id 0)
            }

            if ($floor->canPark($vehicleSize)) {
                $floor->park($vehicleSize);
                return "Welcome, please go in";
            }
        }
        return "Sorry, no spaces left";
    }
}
?>

