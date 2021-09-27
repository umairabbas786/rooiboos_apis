<?php

use Carbon\Carbon;

class ToggleDriverSeekingRides extends Cab5Api {

    private ?DriverEntity $driverEntity;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onDevise() {
        $this->driverEntity->setSeekingRides(!$this->driverEntity->isSeekingRides());

        if (!$this->driverEntity->isSeekingRides()) {
            $this->driverEntity->setTotalMeters(0);
        }

        $this->driverEntity->setSneakedAt(Carbon::now());

        $this->driverEntity = $this->getCab5db()->getDriverDao()->updateDriverSeekingRidesStatus($this->driverEntity);

        if ($this->driverEntity === null) {
            $this->killAsFailure([
                'failed_to_update_status_online' => true
            ]);
        }

        $this->resSendOK([
            DriverTableSchema::SEEKING_RIDES => $this->driverEntity->isSeekingRides()
        ]);
    }
}