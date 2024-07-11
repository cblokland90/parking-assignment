<?php

namespace TheInnerCircle\Entity\ValueObject;

final readonly class Van extends Vehicle
{
    public function __construct()
    {
        parent::__construct(1.5);
    }
}
