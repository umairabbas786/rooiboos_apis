<?php

use Carbon\Carbon;

class AddFreeKilometersToDrivers extends Cab5Api {

    protected function onDevise() {
        $freeDistanceEntity = $this->getCab5db()->getFreeDistanceDao()->getFreeDistanceEntity();
        $allDrivers = $this->getCab5db()->getDriverDao()->getAllOnlineDrivers();

        /** @var DriverEntity $driver */
        foreach ($allDrivers as $driver) {
            $sneakedTime = new Carbon($driver->getSneakedAt());

            $diffInHours = $sneakedTime->diffInHours(Carbon::now());

            if ($diffInHours >= 1) {
                $driverPreviousMeters = $driver->getTotalMeters();
                $driver->setTotalMeters($driverPreviousMeters + $freeDistanceEntity->getDistanceInMeters());
                $driver->setSneakedAt(Carbon::now());

                $this->getCab5db()->getDriverDao()->updateDriverTotalMetersWithSneakedAt($driver);
            }
        }
    }
}