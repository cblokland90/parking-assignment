<?php

namespace TheInnerCircle\Entity\ValueObject;

final readonly class Car extends Vehicle
{
    public function __construct()
    {
        parent::__construct(1.0);
    }
}
