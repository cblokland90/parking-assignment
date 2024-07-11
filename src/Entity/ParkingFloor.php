<?php

namespace TheInnerCircle\Entity;

use TheInnerCircle\Entity\Exception\OutOfParkingSpotsException;
use TheInnerCircle\Entity\Exception\VehicleTypeNotAllowedException;
use TheInnerCircle\Entity\ValueObject\Vehicle;

final class ParkingFloor
{
    private float $consumedSpace = 0.0;

    /**
     * @param array $allowedVehicleTypes ie. [Car::class, Van::class]
     * @param float $size
     */
    public function __construct(
        public readonly array $allowedVehicleTypes,
        public readonly float $size
    ) {
    }

    public function park(Vehicle $vehicle): void
    {
        if (!$this->hasSpace($vehicle)) {
            throw new OutOfParkingSpotsException();
        }

        $this->consumedSpace += $vehicle->size;
    }

    private function hasSpace(Vehicle $vehicle): bool
    {
        if (!$this->isAllowedType($vehicle)) {
            throw new VehicleTypeNotAllowedException();
        }

        return $this->consumedSpace + $vehicle->size <= $this->size;
    }

    private function isAllowedType(Vehicle $vehicle): bool
    {
        return in_array(get_class($vehicle), $this->allowedVehicleTypes);
    }

    public function getAvailableParkingSpots(Vehicle $vehicle): int
    {
        if (!$this->isAllowedType($vehicle)) {
            return 0;
        }

        $sizeRemaining = $this->size - $this->consumedSpace;
        return floor($sizeRemaining / $vehicle->size);
    }
}
