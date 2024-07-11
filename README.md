# Parking Garage Assignment

This assignment demonstrates a simple parking garage system that can park cars, vans, and motorbikes. The garage automatically checks if a certain vehicle type is allowed on any floor and if the floor has enough space left.

Check out `test.php` for a usage example. More in-depth scenarios are shown in `tests/Functional/Entity/ParkingGarageTest.php`

# Problem Statement
The goal is to create a parking garage software solution with the following features:

- Support for multiple vehicle types: cars, vans, and motorcycles.
- Different sizes for each vehicle type.
- Three floors with different capacities.
- Vans can only park on the ground floor.
- Proper messages when a vehicle can or cannot be parked.

# Architecture

The project is structured as follows:

- Entities: Core classes (ParkingGarage, ParkingFloor, Vehicle, and its subclasses).
- Exceptions: Custom exceptions (OutOfParkingSpotsException, VehicleTypeNotAllowedException).
- Tests: PHPUnit tests to verify the functionality.

# Key Classes

- ParkingGarage: Manages multiple floors and handles the parking logic.
- ParkingFloor: Represents a floor in the parking garage and manages parking spots.
- Vehicle and its subclasses (Car, Van, MotorBike): Define different vehicle types and their sizes.

# Setting up locally

1. Clone the repository
1. Run `docker compose build`
1. Install vendors: `docker compose run app composer install`
1. Check everything works: `docker compose run app php -v`

# Running the code

1. Run `docker compose run app php test.php`

# Running the tests

1. Run `docker compose run app php vendor/bin/phpunit ./tests`
