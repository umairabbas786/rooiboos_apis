<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class RegisterDriver extends Cab5Api {

    const PHONE = "phone";
    const FIRST_NAME = "first_name";
    const LAST_NAME = "last_name";
    const EMAIL = "email";
    const CITY_ID = "city_id";
    const RIDE_CATEGORY_ID = "ride_category_id";
    const AVATAR = "avatar";

    protected function onAssemble() {
        $required_fields = [self::PHONE, self::FIRST_NAME, self::LAST_NAME, self::EMAIL, self::CITY_ID, self::RIDE_CATEGORY_ID];

        foreach ($required_fields as $required_field) {
            if (!isset($_POST[$required_field])) {
                $this->killAsBadRequestWithMissingParamException($required_field);
            }
        }

        if (!isset($_FILES[self::AVATAR])) {
            $this->killAsBadRequestWithMissingParamException(self::AVATAR);
        }
    }

    protected function onDevise() {
        $generatedName = "";
        $isImageSaved = ImageUploader::withSrc($_FILES[self::AVATAR]['tmp_name'])
            ->destinationDir($this->getDriverAvatarImagesDirectory())
            ->generateUniqueName($_FILES[self::AVATAR]['name'])
            ->mapGeneratedName($generatedName)
            ->compressQuality(75)
            ->save();

        $driverEntity = $this->getCab5db()->getDriverDao()->getDriverWithPhone($_POST[self::PHONE]);

        if ($driverEntity !== null) {
            $this->killAsFailure([
                "driver_already_registered" => true
            ]);
        }

        $rideCategoryEntity = $this->getCab5db()->getRideCategoryDao()->getRideCategoryWithID($_POST[self::RIDE_CATEGORY_ID]);

        if ($rideCategoryEntity === null) {
            $this->killAsGoneRequest([
                "requested_ride_category_is_no_more_available" => true
            ]);
        }

        $cityEntity = $this->getCab5db()->getCityDao()->getCityWithId($_POST[self::CITY_ID]);

        if ($cityEntity === null) {
            $this->killAsGoneRequest([
                "requested_city_is_no_more_available" => true
            ]);
        }

        if (!$isImageSaved) {
            $this->killAsFailure([
                "failed_to_save_avatar" => true
            ]);
        }

        $registration_time = Carbon::now();

        $freeDistanceEntity = $this->getCab5db()->getFreeDistanceDao()->getFreeDistanceEntity();

        $driverEntity = new DriverEntity(
            Uuid::uuid4()->toString(),
            $_POST[self::FIRST_NAME],
            $_POST[self::LAST_NAME],
            null,
            $_POST[self::EMAIL],
            'NONE',
            'NONE',
            $_POST[self::PHONE],
            false,
            true,
            bin2hex(openssl_random_pseudo_bytes(44)),
            true,
            $_POST[self::CITY_ID],
            null,
            null,
            null,
            $registration_time,
            $freeDistanceEntity === null ? (15 * 1000) : $freeDistanceEntity->getDistanceInMeters(),
            0,
            false,
            $registration_time,
            $registration_time
        );

        $driverAvatarEntity = new DriverAvatarEntity(
            Uuid::uuid4()->toString(),
            $driverEntity->getId(),
            $generatedName,
            $registration_time,
            $registration_time
        );

        $driverAvatarEntity = $this->getCab5db()->getDriverAvatarDao()->insertAvatar($driverAvatarEntity);

        if ($driverAvatarEntity === null) {
            $this->killAsFailure([
                'failed_to_persist_avatar_record' => true
            ]);
        }

        $driverRideCategoryEntity = new DriverRideCategoryEntity(
            Uuid::uuid4()->toString(),
            $driverEntity->getId(),
            $rideCategoryEntity->getId(),
            $registration_time,
            $registration_time
        );

        $driverRideCategoryEntity = $this->getCab5db()->getDriverRideCategoryDao()->insertDriverRideCategory($driverRideCategoryEntity);

        if ($driverRideCategoryEntity === null) {
            $this->killAsFailure([
                'failed_to_persist_driver_ride_category_record' => true
            ]);
        }

        $driverEntity = $this->getCab5db()->getDriverDao()->insertDriver($driverEntity);

        if ($driverEntity === null) {
            $this->killAsFailure([
                'failed_to_persist_driver' => true
            ]);
        }

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
            'ride_category' => [
                RideCategoryTableSchema::ID => $rideCategoryEntity->getId()
            ],
            'avatar' => [
                DriverAvatarTableSchema::AVATAR => $this->createLinkForDriverAvatarImage($driverAvatarEntity->getAvatar())
            ]
        ]);
    }
}