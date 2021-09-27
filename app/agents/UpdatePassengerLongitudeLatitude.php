<?php

class UpdatePassengerLongitudeLatitude extends Cab5Api {

    const LONGITUDE = "lng";
    const LATITUDE = "lat";

    private PassengerEntity $passengerEntity;

    protected function onTokenAuthorization() {
        $this->passengerEntity = $this->handlePassengerTokenAuthorization();
    }

    protected function onAssemble() {
        if (!isset($_POST[self::LONGITUDE])) {
            $this->killAsBadRequestWithMissingParamException(self::LONGITUDE);
        }
        if (!isset($_POST[self::LATITUDE])) {
            $this->killAsBadRequestWithMissingParamException(self::LATITUDE);
        }
    }

    protected function onDevise() {
        $this->resSendOK([
            "updated" => $this->getCab5db()
                ->getPassengerDao()
                ->updatePassengerLongitudeLatitude($this->passengerEntity->getId(), $_POST[self::LONGITUDE], $_POST[self::LATITUDE])
        ]);
    }
}