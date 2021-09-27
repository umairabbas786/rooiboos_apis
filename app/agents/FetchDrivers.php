<?php


class FetchDrivers extends Cab5Api {

    /** @var array */
    private array $drivers;

    protected function onAssemble() {
        $this->drivers = $this->getCab5db()->getDriverDao()->getAllDrivers();
    }

    protected function onDevise() {
        $response = [];

        /** @var DriverEntity $driver */
        foreach ($this->drivers as $driver) {
            $avatar = $this->getCab5db()->getDriverAvatarDao()->getAvatarOfDriver($driver->getId());

            $cityEntity = $this->getCab5db()->getCityDao()->getCityWithId($driver->getCityId());

            $driverRideCategories = $this->getCab5db()->getDriverRideCategoryDao()->getDriverRideCategoriesByDriverId($driver->getId());
            $rideCategories = [];

            /** @var DriverRideCategoryEntity $driverRideCategory */
            foreach ($driverRideCategories as $driverRideCategory) {
                $rideCategoryEntity = $this->getCab5db()->getRideCategoryDao()->getRideCategoryWithID($driverRideCategory->getRideCategoryId());
                array_push($rideCategories, [
                    RideCategoryTableSchema::ID => $rideCategoryEntity->getId(),
                    RideCategoryTableSchema::NAME => $rideCategoryEntity->getName(),
                    RideCategoryTableSchema::IMAGE => $this->createLinkForRideCategoryImage($rideCategoryEntity->getImage()),
                    RideCategoryTableSchema::ENABLED => $rideCategoryEntity->isEnabled(),
                    RideCategoryTableSchema::PRICE => $rideCategoryEntity->getPrice(),
                    RideCategoryTableSchema::PER_KM_COST => $rideCategoryEntity->getPerKmCost(),
                    RideCategoryTableSchema::CREATED_AT => $rideCategoryEntity->getCreatedAt(),
                    RideCategoryTableSchema::UPDATED_AT => $rideCategoryEntity->getUpdatedAt()
                ]);
            }

            $driverCnicEntity = $this->getCab5db()->getDriverCnicDao()->getCnicOfDriver($driver->getId());
            $driverLicenseEntity = $this->getCab5db()->getDriverLicenseDao()->getLicenseOfDriver($driver->getId());
            $driverVehicleNumberPlateEntity = $this->getCab5db()->getDriverVehicleNumberPlateDao()->getDriverVehicleNumberPlate($driver->getId());

            $data = [
                'driver' => [
                    DriverTableSchema::ID => $driver->getId(),
                    DriverTableSchema::FIRST_NAME => $driver->getFirstName(),
                    DriverTableSchema::LAST_NAME => $driver->getLastName(),
                    DriverTableSchema::EMAIL => $driver->getEmail(),
                    DriverTableSchema::PHONE => $driver->getPhone(),
                    DriverTableSchema::BLOCKED => $driver->isBlocked(),
                    DriverTableSchema::CREATED_AT => $driver->getCreatedAt(),
                ],
                "city" => [
                    CityTableSchema::NAME => $cityEntity->getName(),
                ],
                "ride_categories" => $rideCategories,
                "avatar" => [
                    DriverAvatarTableSchema::AVATAR => $this->createLinkForDriverAvatarImage($avatar->getAvatar()),
                ],
                "cnic" => $driverCnicEntity === null ? null : [
                    DriverCnicTableSchema::CNIC_FRONT => $this->createLinkForDriverCnicImage($driverCnicEntity->getCnicFront()),
                    DriverCnicTableSchema::CNIC_BACK => $this->createLinkForDriverCnicImage($driverCnicEntity->getCnicBack()),
                ],
                "license" => $driverLicenseEntity === null ? null : [
                    DriverLicenseTableSchema::LICENSE_FRONT => $this->createLinkForDriverLicenseImage($driverLicenseEntity->getLicenseFront()),
                    DriverLicenseTableSchema::LICENSE_BACK => $this->createLinkForDriverLicenseImage($driverLicenseEntity->getLicenseBack()),
                ],
                "number_plate" => $driverVehicleNumberPlateEntity === null ? null : [
                    DriverVehicleNumberPlateTableSchema::NUMBER_PLATE => $this->createLinkForDriverVehicleNumberPlateImage($driverVehicleNumberPlateEntity->getNumberPlate()),
                ]
            ];

            $magicianPayload = $this->getMagician()->encrypt($driver->getToken());

            Cab5Response::mapAuthTokenToData(
                $data,
                $magicianPayload->getAbracadabra(),
                $magicianPayload->getEncryptedPayload()
            );

            array_push($response, $data);
        }

        $this->resSendOk([
            "drivers" => $response
        ]);
    }
}