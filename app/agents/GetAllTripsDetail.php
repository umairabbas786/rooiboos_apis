<?php

class GetAllTripsDetail extends Cab5Api {

    protected function onDevise() {
        $trips = $this->getCab5db()->getRideDao()->getAllCompletedRides();

        $data = [];

        /** @var RideEntity $ride */
        foreach ($trips as $ride) {
            $driver = $this->getCab5db()->getDriverDao()->getDriverWithId($ride->getDriverId());
            $passenger = $this->getCab5db()->getPassengerDao()->getPassengerWithId($ride->getPassengerId());

            array_push($data, [
                'trip_id' => $ride->getId(),
                'driver_first_name' => $driver->getFirstName(),
                'driver_last_name' => $driver->getLastName(),
                'passenger_first_name' => $passenger->getFirstName(),
                'passenger_last_name' => $passenger->getLastName(),
                'driver_phone' => $driver->getPhone(),
                'ride_date' => $ride->getCreatedAt(),
                'pickup_location' => $ride->getPickupLocationName(),
                'exit_location' => $ride->getExitLocationName()
            ]);
        }

        $this->resSendOK([
            'trips' => $data
        ]);
    }
}