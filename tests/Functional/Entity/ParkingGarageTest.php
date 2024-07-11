<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TheInnerCircle\Entity\Exception\OutOfParkingSpotsException;
use TheInnerCircle\Entity\ParkingFloor;
use TheInnerCircle\Entity\ParkingGarage;
use TheInnerCircle\Entity\ValueObject\Car;
use TheInnerCircle\Entity\ValueObject\MotorBike;
use TheInnerCircle\Entity\ValueObject\Van;

class ParkingGarageTest extends TestCase
{
    public static function parkDataProvider()
    {
        yield 'can park in empty garage' => [
            'floors' => [
                new ParkingFloor(allowedVehicleTypes: [Car::class], size: 10.0)
            ],
            'parkingQueue' => [
                [true, new Car()]
            ]
        ];

        yield 'cant park in full garage' => [
            'floors' => [
                new ParkingFloor(allowedVehicleTypes: [Car::class], size: 1.0)
            ],
            'parkingQueue' => [
                [true, new Car()],
                [false, new Car()]
            ]
        ];

        yield 'cant park a type that is not allowed at any floor' => [
            'floors' => [
                new ParkingFloor(allowedVehicleTypes: [Car::class], size: 5.0),
                new ParkingFloor(allowedVehicleTypes: [MotorBike::class], size: 5.0)
            ],
            'parkingQueue' => [
                [false, new Van()],
            ]
        ];

        yield 'can consume all space in single floor with all types' => [
            'floors' => [
                new ParkingFloor(allowedVehicleTypes: [Car::class, Van::class, MotorBike::class], size: 3.0)
            ],
            'parkingQueue' => [
                [true, new Van()],
                [true, new Car()],
                [true, new MotorBike()],
                [false, new MotorBike()],
            ]
        ];


        yield 'can consume all space in multiple floors with all types' => [
            'floors' => [
                new ParkingFloor(allowedVehicleTypes: [Van::class], size: 1.5),
                new ParkingFloor(allowedVehicleTypes: [Car::class], size: 2.0),
                new ParkingFloor(allowedVehicleTypes: [MotorBike::class], size: 1.0)
            ],
            'parkingQueue' => [
                // fill floor 1 with all cars possible
                [true, new Car()],
                [true, new Car()],

                // fill floor 0 with single van
                [true, new Van()],

                // fill floor 3 with all motorbikes
                [true, new MotorBike()],
                [true, new MotorBike()],

                // Make sure no vehicles of any type fit anymore
                [false, new Car()],
                [false, new Van()],
                [false, new MotorBike()],
            ]
        ];
    }

    #[DataProvider('parkDataProvider')]
    public function testPark(array $floors, array $parkingQueue)
    {
        $garage = new ParkingGarage($floors);

        foreach ($parkingQueue as $parkingTest) {
            [$expectedCanPark, $vehicle] = $parkingTest;

            try {
                $garage->park($vehicle);
                if (!$expectedCanPark) {
                    $this->fail(sprintf('Expected \'%s\' to be thrown', OutOfParkingSpotsException::class));
                }
                $this->assertTrue(true);
            } catch (OutOfParkingSpotsException $e) {
                if (!$expectedCanPark) {
                    $this->assertTrue(true);
                    continue;
                }

                $this->fail("Unexpected parking spots available, shouldn't be able to park");
            }
        }
    }

    public function testAvailableParkingSpotsIsReportedCorrectly()
    {
        $garage = new ParkingGarage(floors: [
            new ParkingFloor(allowedVehicleTypes: [Car::class, Van::class, MotorBike::class], size: 3.0),
        ]);

        self::assertEquals(3, $garage->getAvailableParkingSpots(new Car()));
        self::assertEquals(6, $garage->getAvailableParkingSpots(new MotorBike()));
        self::assertEquals(2, $garage->getAvailableParkingSpots(new Van()));

        $garage->park(new MotorBike());

        self::assertEquals(5, $garage->getAvailableParkingSpots(new MotorBike()));
        self::assertEquals(1, $garage->getAvailableParkingSpots(new Van()));
        self::assertEquals(2, $garage->getAvailableParkingSpots(new Car()));
    }
}
