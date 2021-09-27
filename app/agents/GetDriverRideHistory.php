<?php

class GetDriverRideHistory extends Cab5Api {

    private DriverEntity $driverEntity;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onDevise() {
        $rides = $this->getCab5db()->getRideDao()->getDriverCompletedRides($this->driverEntity->getId());

        $response = [];

        /** @var RideEntity $ride */
        foreach ($rides as $ride) {
            array_push($response, [
                'pickup_location_name' => $ride->getPickupLocationName(),
                'exit_location_name' => $ride->getExitLocationName(),
                'ride_end_time' => $ride->getUpdatedAt(),
                'bill' => $ride->getBill()
            ]);
        }

        $this->resSendOK([
            'history' => $response
        ]);
    }
}