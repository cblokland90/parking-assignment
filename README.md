# Machine Requirements

For this challenge to run, you'll have to use Docker on your machine.

1. Start the Docker containers; `docker compose up -d`

2. Run your tests; `docker compose exec app vendor/bin/phpunit .` 

3. Stop the docker containers; `docker compose down`

Feel free to cahnge any of boilerpalte files in this porject as you need.

Without further ado - good luck with the challenge and, even more importantly, HAVE FUN!

# Assumptions and design decisions

1. Vehicles are more likely to change then parking floor. Thats why vehicle is a separate entity and parking floor is a property of parking lot. Making a floors a separate entity would have made the system more complex and would have required more time to implement.
2. Example in ParkingExample.php with a loop to park vehicles is for the person who reviews this code more convenient, then having to call the script many times with different parameters.
3. The more vehicles can park, the better. The less vehicles have to drive, the better. That is why vehicles are parked in the nearest available spot (first floor instead of second floor), while reverving ground floor for vans as much as possible.
4. Programming language is PHP
5. Run example script with: `php ParkingExample.php`
6. Run tests script with: `docker compose exec app php vendor/bin/phpunit ParkingGarageTest.php`