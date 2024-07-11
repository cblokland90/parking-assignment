<?php

namespace TheInnerCircle\Entity\ValueObject;

final readonly class MotorBike extends Vehicle
{
    public function __construct()
    {
        parent::__construct(0.5);
    }

}
