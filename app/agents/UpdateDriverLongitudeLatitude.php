<?php

use Carbon\Carbon;
use Location\Coordinate;
use Location\Distance\Haversine;

class UpdateDriverLongitudeLatitude extends Cab5Api {

    const LONGITUDE = "lng";
    const LATITUDE = "lat";

    const LOCATION_NAME = "location_name";

    private DriverEntity $driverEntity;
    private Haversine $haversineCalculator;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onAssemble() {
        if (!isset($_POST[self::LOCATION_NAME])) {
            $this->killAsBadRequestWithMissingParamException(self::LOCATION_NAME);
        }
        if (!isset($_POST[self::LONGITUDE])) {
            $this->killAsBadRequestWithMissingParamException(self::LONGITUDE);
        }
        if (!isset($_POST[self::LATITUDE])) {
            $this->killAsBadRequestWithMissingParamException(self::LATITUDE);
        }

        $this->haversineCalculator = new Haversine();
    }

    protected function onDevise() {
        $engagedRide = $this->getCab5db()->getRideDao()->getCurrentRideOfDriver($this->driverEntity->getId());

        if ($engagedRide !== null) {
            if ($engagedRide->getState() === RideState::USER_STARTED_RIDE) {
                if ($engagedRide->getMetersTravelled() === null) {
                    $engagedRide->setMetersTravelled(0);
                } else {
                    $driver_prev_coordinate = new Coordinate($this->driverEntity->getLatitude(), $this->driverEntity->getLongitude());
                    $driver_new_coordinate = new  Coordinate($_POST[self::LATITUDE], $_POST[self::LONGITUDE]);
                    $distance = $driver_prev_coordinate->getDistance($driver_new_coordinate, $this->haversineCalculator); // returns in Meter

                    $engagedRide->setMetersTravelled($engagedRide->getMetersTravelled() + $distance);
                    $engagedRide->setExitLocationName($_POST[self::LOCATION_NAME]);
                    $engagedRide->setUpdatedAt(Carbon::now());
                }
                $this->getCab5db()->getRideDao()->updateRideEntity($engagedRide); // Update in db
            }
        }

        $this->resSendOK([
            "updated" => $this->getCab5db()->getDriverDao()->updateDriverLongitudeLatitude(
                $this->driverEntity->getId(),
                $_POST[self::LONGITUDE],
                $_POST[self::LATITUDE]
            )
        ]);
    }
}