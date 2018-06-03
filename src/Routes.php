<?php declare(strict_types=1);

namespace ClickAndBoat;

/**
 * Class Routes
 * @package ClickAndBoat
 */
class Routes
{
    /**
     * @return array
     */
    public static function getRoutes()
    {
        return [
            ['GET', '/', ['ClickAndBoat\Controllers\Homepage', 'show']],

            ['GET', '/showBoat/{id:\d+}', ['ClickAndBoat\Controllers\VehicleController', 'showBoat']],
            ['GET', '/showScooter/{id:\d+}', ['ClickAndBoat\Controllers\VehicleController', 'showScooter']],

            ['GET', '/showBoats', ['ClickAndBoat\Controllers\VehicleController', 'showBoats']],
            ['POST', '/showBoats', ['ClickAndBoat\Controllers\VehicleController', 'showBoats']],
            ['GET', '/showScooters', ['ClickAndBoat\Controllers\VehicleController', 'showScooters']],
            ['POST', '/showScooters', ['ClickAndBoat\Controllers\VehicleController', 'showScooters']],

            ['GET', '/createBoat', ['ClickAndBoat\Controllers\VehicleController', 'createBoat']],
            ['POST', '/createBoat', ['ClickAndBoat\Controllers\VehicleController', 'createBoat']],
            ['GET', '/createScooter', ['ClickAndBoat\Controllers\VehicleController', 'createScooter']],
            ['POST', '/createScooter', ['ClickAndBoat\Controllers\VehicleController', 'createScooter']],


        ];
    }
}

