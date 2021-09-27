<?php

class UpdatePassengerFcmToken extends Cab5Api {

    const FCM_TOKEN = "fcm_token";

    private PassengerEntity $passengerEntity;

    protected function onTokenAuthorization() {
        $this->passengerEntity = $this->handlePassengerTokenAuthorization();
    }

    protected function onAssemble() {
        if (!isset($_POST[self::FCM_TOKEN])) {
            $this->killAsBadRequestWithMissingParamException(self::FCM_TOKEN);
        }
    }

    protected function onDevise() {
        $this->resSendOK([
            "updated" => $this->getCab5db()
                ->getPassengerDao()
                ->updatePassengerFCMToken($this->passengerEntity->getId(), $_POST[self::FCM_TOKEN])
        ]);
    }
}