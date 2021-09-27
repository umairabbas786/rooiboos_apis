<?php

class RejectDriverRideNotification extends Cab5Api {

    const RIDE_ID = "ride_id";


    protected function onTokenAuthorization() {
        $this->handleDriverTokenAuthorization();
    }

    protected function onAssemble() {
        if (!isset($_POST[self::RIDE_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::RIDE_ID);
        }
    }

    protected function onDevise() {
        if (!$this->getCab5db()->getRideDao()->deleteRideWithRideId($_POST[self::RIDE_ID])) {
            $this->killAsFailure([
                'failed_to_reject_ride' => true
            ]);
        }

        $this->resSendOK([
            'ride_rejected_successfully' => true
        ]);
    }
}