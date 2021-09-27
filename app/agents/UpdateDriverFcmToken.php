<?php

class UpdateDriverFcmToken extends Cab5Api {

    const FCM_TOKEN = "fcm_token";

    private DriverEntity $driverEntity;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onAssemble() {
        if (!isset($_POST[self::FCM_TOKEN])) {
            $this->killAsBadRequestWithMissingParamException(self::FCM_TOKEN);
        }
    }

    protected function onDevise() {
        $this->resSendOK([
            "updated" => $this->getCab5db()
                ->getDriverDao()
                ->updateDriverFCMToken($this->driverEntity->getId(), $_POST[self::FCM_TOKEN])
        ]);
    }
}