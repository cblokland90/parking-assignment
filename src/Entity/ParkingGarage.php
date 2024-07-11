<?php

namespace TheInnerCircle\Entity;

use TheInnerCircle\Entity\Exception\OutOfParkingSpotsException;
use TheInnerCircle\Entity\Exception\VehicleTypeNotAllowedException;
use TheInnerCircle\Entity\ValueObject\Vehicle;

final readonly class ParkingGarage
{
    public function __construct(
        /** @var ParkingFloor[] */
        public array $floors
    ) {
    }

    public function park(Vehicle $vehicle): void
    {
        foreach ($this->floors as $floor) {
            try {
                $floor->park($vehicle);
                return;
            } catch (OutOfParkingSpotsException|VehicleTypeNotAllowedException $e) {
                continue;
            }
        }

        // Failed to park at any floor, out of space or no floor allows this type
        // To keep it simple let's assume that the garage is full
        throw new OutOfParkingSpotsException();
    }

    public function getAvailableParkingSpots(Vehicle $vehicle): int
    {
        $availableSpots = 0;
        foreach ($this->floors as $floor) {
            $availableSpots += $floor->getAvailableParkingSpots($vehicle);
        }
        return $availableSpots;
    }
}
