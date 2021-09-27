<?php

class GetPassengerRideHistory extends Cab5Api {

    private PassengerEntity $passengerEntity;

    protected function onTokenAuthorization() {
        $this->passengerEntity = $this->handlePassengerTokenAuthorization();
    }

    protected function onDevise() {
        $rides = $this->getCab5db()->getRideDao()->getPassengerCompletedRides($this->passengerEntity->getId());

        $response = [];

        /** @var RideEntity $ride */
        foreach ($rides as $ride) {
            $rideCategory = $this->getCab5db()->getRideCategoryDao()->getRideCategoryWithID($ride->getRideCategoryId());

            $driver = $this->getCab5db()->getDriverDao()->getDriverWithId($ride->getDriverId());

            array_push($response, [
                'pickup_location_name' => $ride->getPickupLocationName(),
                'driver_first_name' => $driver->getFirstName(),
                'driver_last_name' => $driver->getLastName(),
                'ride_category_name' => $rideCategory->getName(),
                'exit_location_name' => $ride->getExitLocationName(),
                'ride_end_time' => $ride->getUpdatedAt(),
            ]);
        }

        $this->resSendOK([
            'history' => $response
        ]);
    }
}