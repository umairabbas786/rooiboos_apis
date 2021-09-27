<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class RegisterPassenger extends Cab5Api {

    const PHONE = "phone";
    const FIRST_NAME = "first_name";
    const LAST_NAME = "last_name";
    const EMAIL = "email";
    const AVATAR = "avatar";

    protected function onAssemble() {
        $required_fields = [self::PHONE, self::FIRST_NAME, self::LAST_NAME, self::EMAIL];

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
            ->destinationDir($this->getPassengerAvatarImagesDirectory())
            ->generateUniqueName($_FILES[self::AVATAR]['name'])
            ->mapGeneratedName($generatedName)
            ->compressQuality(75)
            ->save();

        if (!$isImageSaved) {
            $this->killAsFailure([
                "failed_to_save_avatar" => true
            ]);
        }

        $registration_time = Carbon::now();

        $passengerEntity = new PassengerEntity(
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
            null,
            null,
            null,
            0,
            false,
            $registration_time,
            $registration_time
        );

        $avatarEntity = new PassengerAvatarEntity(
            Uuid::uuid4()->toString(),
            $passengerEntity->getId(),
            $generatedName,
            $registration_time,
            $registration_time
        );

        $avatarEntity = $this->getCab5db()->getPassengerAvatarDao()->insertAvatar($avatarEntity);

        if ($avatarEntity === null) {
            $this->killAsFailure([
                'failed_to_create_avatar' => true
            ]);
        }

        if ($this->getCab5db()->getPassengerDao()->getPassengerWithPhone($_POST[self::PHONE]) === null) {
            $passengerEntity = $this->getCab5db()->getPassengerDao()->insertPassenger($passengerEntity);

            if ($passengerEntity === null) {
                $this->killAsFailure([
                    "failed_to_create_passenger" => true
                ]);
            }
        } else {
            $this->killAsFailure([
                "passenger_already_registered" => true
            ]);
        }

        $this->resSendOkWithAuthorizationToken($passengerEntity->getToken(), [
            'passenger' => [
                PassengerTableSchema::ID => $passengerEntity->getId(),
                PassengerTableSchema::FIRST_NAME => $passengerEntity->getFirstName(),
                PassengerTableSchema::LAST_NAME => $passengerEntity->getLastName(),
                PassengerTableSchema::USERNAME => $passengerEntity->getUsername(),
                PassengerTableSchema::EMAIL => $passengerEntity->getEmail(),
                PassengerTableSchema::PHONE => $passengerEntity->getPhone(),
                PassengerTableSchema::VERIFIED_EMAIL => $passengerEntity->isVerifiedEmail(),
                PassengerTableSchema::VERIFIED_PHONE => $passengerEntity->isVerifiedPhone(),
                PassengerTableSchema::LONGITUDE => $passengerEntity->getLongitude(),
                PassengerTableSchema::LATITUDE => $passengerEntity->getLatitude(),
                PassengerTableSchema::FCM_TOKEN => $passengerEntity->getFcmToken(),
                PassengerTableSchema::CREATED_AT => $passengerEntity->getCreatedAt(),
                PassengerTableSchema::UPDATED_AT => $passengerEntity->getUpdatedAt(),
            ],
            'avatar' => [
                PassengerAvatarTableSchema::AVATAR => $avatarEntity->getAvatar()
            ]
        ]);
    }
}