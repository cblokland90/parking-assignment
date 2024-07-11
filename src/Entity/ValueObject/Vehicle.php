<?php

namespace TheInnerCircle\Entity\ValueObject;

abstract readonly class Vehicle
{
    public function __construct(public float $size)
    {
    }
}
