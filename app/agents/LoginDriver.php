<?php


class LoginDriver extends Cab5Api {

    const PHONE = "phone";

    protected function onAssemble() {
        if (!isset($_POST[self::PHONE])) {
            $this->killAsBadRequestWithMissingParamException(self::PHONE);
        }
    }

    protected function onDevise() {
        $driverEntity = $this->getCab5db()->getDriverDao()->getDriverWithPhone($_POST[self::PHONE]);
        
        if ($driverEntity === null) {
            $this->killAsFailure([
                'no_driver_found' => true
            ]);
        }
        
        $avatarEntity = $this->getCab5db()->getDriverAvatarDao()->getAvatarOfDriver($driverEntity->getId());
        
        if ($avatarEntity === null) {
            $this->killAsCompromised([
                'avatar_not_found' => true
            ]);
        }
        
        $cityEntity = $this->getCab5db()->getCityDao()->getCityWithId($driverEntity->getCityId());

        if ($cityEntity === null) {
            $this->killAsGoneRequest([
                'driver_city_could_not_be_found' => true
            ]);
        }

        $driverRideCategories = $this->getCab5db()->getDriverRideCategoryDao()->getDriverRideCategoriesByDriverId($driverEntity->getId());

        $rideCategoriesIds = [];

        /** @var DriverRideCategoryEntity $driverRideCategory */
        foreach ($driverRideCategories as $driverRideCategory) {
            array_push($rideCategoriesIds, $driverRideCategory->getRideCategoryId());
        }

        $driverCnicEntity = $this->getCab5db()->getDriverCnicDao()->getCnicOfDriver($driverEntity->getId());
        $driverLicenseEntity = $this->getCab5db()->getDriverLicenseDao()->getLicenseOfDriver($driverEntity->getId());
        $driverVehicleNumberPlateEntity = $this->getCab5db()->getDriverVehicleNumberPlateDao()->getDriverVehicleNumberPlate($driverEntity->getId());

        $this->resSendOkWithAuthorizationToken($driverEntity->getToken(), [
            'driver' => [
                DriverTableSchema::ID => $driverEntity->getId(),
                DriverTableSchema::FIRST_NAME => $driverEntity->getFirstName(),
                DriverTableSchema::LAST_NAME => $driverEntity->getLastName(),
                DriverTableSchema::EMAIL => $driverEntity->getEmail(),
                DriverTableSchema::PHONE => $driverEntity->getPhone(),
                DriverTableSchema::VERIFIED_EMAIL => $driverEntity->isVerifiedEmail(),
                DriverTableSchema::VERIFIED_PHONE => $driverEntity->isVerifiedPhone(),
                DriverTableSchema::CITY_ID => $driverEntity->getCityId(),
                DriverTableSchema::SEEKING_RIDES => $driverEntity->isSeekingRides(),
                DriverTableSchema::CREATED_AT => $driverEntity->getCreatedAt(),
                DriverTableSchema::UPDATED_AT => $driverEntity->getUpdatedAt()
            ],
            'ride_categories_ids' => $rideCategoriesIds,
            'avatar' => [
                DriverAvatarTableSchema::AVATAR => $this->createLinkForDriverAvatarImage($avatarEntity->getAvatar())
            ],
            "cnic" => $driverCnicEntity === null ? null : [
                DriverCnicTableSchema::CNIC_FRONT => $this->createLinkForDriverCnicImage($driverCnicEntity->getCnicFront()),
                DriverCnicTableSchema::CNIC_BACK => $this->createLinkForDriverCnicImage($driverCnicEntity->getCnicBack())
            ],
            "license" => $driverLicenseEntity === null ? null : [
                DriverLicenseTableSchema::LICENSE_FRONT => $this->createLinkForDriverLicenseImage($driverLicenseEntity->getLicenseFront()),
                DriverLicenseTableSchema::LICENSE_BACK => $this->createLinkForDriverLicenseImage($driverLicenseEntity->getLicenseBack())
            ],
            "number_plate" => $driverVehicleNumberPlateEntity === null ? null : [
                DriverVehicleNumberPlateTableSchema::NUMBER_PLATE => $this->createLinkForDriverVehicleNumberPlateImage($driverVehicleNumberPlateEntity->getNumberPlate())
            ]
        ]);
    }
}
