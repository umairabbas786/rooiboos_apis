<?php

class GetDriverRideStats extends Cab5Api {

    private DriverEntity $driverEntity;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onDevise() {
        $my_current_ride = $this->getCab5db()->getRideDao()->getCurrentRideOfDriver($this->driverEntity->getId());

        if ($my_current_ride === null) {
            $this->killAsFailure([
                'no_ride_found' => true
            ]);
        }

        $this->resSendOK([
            'ride_meta' => [
                RideTableSchema::ID => $my_current_ride->getId(),
                RideTableSchema::DRIVER_ID => $my_current_ride->getDriverId(),
                RideTableSchema::PICKUP_LONGITUDE => $my_current_ride->getPickupLongitude(),
                RideTableSchema::PICKUP_LATITUDE => $my_current_ride->getPickupLatitude(),
                RideTableSchema::STATE => $my_current_ride->getState(),
                RideTableSchema::METERS_TRAVELLED => $my_current_ride->getMetersTravelled(),
                RideTableSchema::CREATED_AT => $my_current_ride->getCreatedAt(),
                RideTableSchema::UPDATED_AT => $my_current_ride->getUpdatedAt()
            ]
        ]);
    }
}