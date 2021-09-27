<?php


class LoginPassenger extends Cab5Api {

    const PHONE = "phone";

    protected function onAssemble() {
        if (!isset($_POST[self::PHONE])) {
            $this->killAsBadRequestWithMissingParamException(self::PHONE);
        }
    }

    protected function onDevise() {
        $passengerEntity = $this->getCab5db()->getPassengerDao()->getPassengerWithPhone($_POST[self::PHONE]);

        if ($passengerEntity === null) {
            $this->killAsFailure([
                'no_passenger_found' => true
            ]);
        }

        $avatarEntity = $this->getCab5db()->getPassengerAvatarDao()->getAvatarOfPassenger($passengerEntity->getId());

        if ($avatarEntity === null) {
            $this->killAsCompromised([
                'avatar_not_found' => true
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