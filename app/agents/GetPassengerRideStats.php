<?php

class GetPassengerRideStats extends Cab5Api {

    private PassengerEntity $passengerEntity;

    protected function onTokenAuthorization() {
        $this->passengerEntity = $this->handlePassengerTokenAuthorization();
    }

    protected function onDevise() {
        $isAnyAwaiting = false;

        $my_current_ride = $this->getCab5db()
            ->getRideDao()
            ->getCurrentRideOfPassengerIfAwaitingMapIt($isAnyAwaiting, $this->passengerEntity->getId());

        if ($isAnyAwaiting) {
            $this->killAsFailure([
                'waiting_for_drivers_to_accept_ride' => true
            ]);
        }

        if ($my_current_ride === null) {
            $this->killAsFailure([
                'no_ride_found' => true
            ]);
        }

        $my_ride_driver = $this->getCab5db()->getDriverDao()->getDriverWithId($my_current_ride->getDriverId());

        if ($my_ride_driver === null) {
            $this->killAsCompromised([
                'no_driver_found' => true
            ]);
        }

        $driver_avatar_entity = $this->getCab5db()->getDriverAvatarDao()->getAvatarOfDriver($my_ride_driver->getId());

        if ($driver_avatar_entity === null) {
            $this->killAsCompromised([
                'driver_avatar_could_not_be_found' => true
            ]);
        }

        $rideCategoryEntity = $this->getCab5db()->getRideCategoryDao()->getRideCategoryWithID($my_current_ride->getRideCategoryId());

        if ($rideCategoryEntity === null) {
            $this->killAsCompromised([
                'ride_category_could_not_be_found' => true
            ]);
        }

        $numberPlateEntity = $this->getCab5db()->getDriverVehicleNumberPlateDao()->getDriverVehicleNumberPlate($my_ride_driver->getId());

        if ($numberPlateEntity === null) {
            $this->killAsCompromised([
                'driver_vehicle_number_plate_could_not_be_found' => true
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
            ],
            'driver_meta' => [
                DriverTableSchema::ID => $my_ride_driver->getId(),
                DriverTableSchema::FIRST_NAME => $my_ride_driver->getFirstName(),
                DriverTableSchema::LAST_NAME => $my_ride_driver->getLastName(),
                DriverTableSchema::PHONE => $my_ride_driver->getPhone(),
                DriverTableSchema::LONGITUDE => $my_ride_driver->getLongitude(),
                DriverTableSchema::LATITUDE => $my_ride_driver->getLatitude(),
                DriverAvatarTableSchema::AVATAR => $this->createLinkForDriverAvatarImage($driver_avatar_entity->getAvatar())
            ],
            'ride_category' => [
                RideCategoryTableSchema::NAME => $rideCategoryEntity->getName(),
                RideCategoryTableSchema::IMAGE => $rideCategoryEntity->getImage()
            ],
            'number_plate_meta' => [
                DriverVehicleNumberPlateTableSchema::NUMBER_PLATE => $this->createLinkForDriverVehicleNumberPlateImage($numberPlateEntity->getNumberPlate())
            ]
        ]);
    }
}
