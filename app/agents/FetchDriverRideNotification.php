<?php

class FetchDriverRideNotification extends Cab5Api {
    private DriverEntity $driverEntity;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onDevise() {
        $notifications = [];

        /** @var RideEntity $ride */
        foreach ($this->getCab5db()->getRideDao()->getNewAvailableRidesForDriver($this->driverEntity->getId()) as $ride) {
            array_push($notifications, [
                RideTableSchema::ID => $ride->getId(),
                RideTableSchema::DRIVER_ID => $ride->getDriverId(),
                RideTableSchema::STATE => $ride->getState(),
                RideTableSchema::CREATED_AT => $ride->getCreatedAt(),
                RideTableSchema::UPDATED_AT => $ride->getUpdatedAt()
            ]);
        }

        $this->resSendOK(['rides_notifications' => $notifications]);
    }
}