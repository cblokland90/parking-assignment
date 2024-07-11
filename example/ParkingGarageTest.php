<?php

namespace example;

use Car;
use Motorcycle;
use ParkingGarage;
use PHPUnit\Framework\TestCase;
use Van;

require_once 'ParkingGarage.php';

/*
 * Test cases for the ParkingGarage class
 *
 * Requirements:
 * When a vehicle arrives at the parking garage, and if there is space available, we should see a message on the screen saying “Welcome, please go in”.
 * When a vehicle arrives at the entrance to the parking garage, and it's full, we should see a message saying “Sorry, no spaces left”.
 * Must accept multiple types of vehicles: cars, vans, motorcycles
 * Each type will have a different size (e.g. 2 motorcycles can park in 1 car spot, a van takes 1.5 car spots).
 * Must have 3 floors, each floor has different capacity.
 * A Van can only park on the ground floor.

 */

class ParkingGarageTest extends TestCase
{

    public function testVehicleSizes()
    {
        $car = new Car();
        $this->assertEquals(1.0, $car->getSize(), "Car size should be 1.0");

        $motorcycle = new Motorcycle();
        $this->assertEquals(0.5, $motorcycle->getSize(), "Motorcycle size should be 0.5");

        $van = new Van();
        $this->assertEquals(1.5, $van->getSize(), "Van size should be 1.5");
    }

    public function testParkingFloorCapacity()
    {
        $floor = new ParkingFloor(1, "Test Floor", 10);
        $this->assertTrue($floor->canPark(1.0), "Floor should be able to park a vehicle of size 1.0");
        $this->assertEquals(10, $floor->getFreeSpaces(), "Initial free spaces should be 10");

        $floor->park(1.0);
        $this->assertEquals(9, $floor->getFreeSpaces(), "Free spaces should be 9 after parking a vehicle of size 1.0");

        $this->assertTrue($floor->canPark(9.0), "Floor should be able to park vehicles of total size 9.0");
        $floor->park(9.0);
        $this->assertEquals(0, $floor->getFreeSpaces(),
            "Free spaces should be 0 after parking vehicles of total size 10.0");

        $this->assertFalse($floor->canPark(1.0), "Floor should not be able to park a vehicle of size 1.0 if it's full");
    }

    public function testParkingGarage()
    {
        $floorData = [
            ['id' => 1, 'name' => 'First Floor', 'capacity' => 3],
            ['id' => 2, 'name' => 'Second Floor', 'capacity' => 3],
            ['id' => 0, 'name' => 'Ground Floor', 'capacity' => 2]
        ];
        $garage = new ParkingGarage($floorData);

        $car = new Car();
        $motorcycle = new Motorcycle();
        $van = new Van();

        // Test parking vehicles
        $this->assertEquals("Welcome, please go in", $garage->parkVehicle($car));
        $this->assertEquals("Welcome, please go in", $garage->parkVehicle($motorcycle));
        $this->assertEquals("Welcome, please go in", $garage->parkVehicle($van));
        // Check that capacities have been reduced correctly
        $this->assertEquals(0.5, $garage->floors[0]->getFreeSpaces(), "Ground floor should have 0.5 free spaces");
        // Check that vans can not park any more
        $this->assertEquals("Sorry, no spaces left", $garage->parkVehicle($van));

        // Fill up the rest of the spaces
        $this->assertEquals("Welcome, please go in", $garage->parkVehicle($car));
        $this->assertEquals("Welcome, please go in", $garage->parkVehicle($motorcycle));
        $this->assertEquals("Welcome, please go in", $garage->parkVehicle($car));
        $this->assertEquals("Welcome, please go in", $garage->parkVehicle($car));
        $this->assertEquals("Welcome, please go in", $garage->parkVehicle($car));
        // Check that a car cannot park any more
        $this->assertEquals("Sorry, no spaces left", $garage->parkVehicle($car));
        // But a motorcycle can
        $this->assertEquals("Welcome, please go in", $garage->parkVehicle($motorcycle));
        // Now all spaces are full, even motorcycles can't park
        $this->assertEquals("Sorry, no spaces left", $garage->parkVehicle($motorcycle));
    }

    public function testFloorNameAndId()
    {
        $floor = new ParkingFloor(1, "Test Floor", 10);
        $this->assertEquals(1, $floor->getId(), "Floor ID should be 1");
        $this->assertEquals("Test Floor", $floor->getName(), "Floor name should be 'Test Floor'");
    }
}

?>
