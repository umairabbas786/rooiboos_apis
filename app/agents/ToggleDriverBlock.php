<?php

class ToggleDriverBlock extends Cab5Api {

    private DriverEntity $driverEntity;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onDevise() {
        $this->driverEntity->setBlocked(!$this->driverEntity->isBlocked());

        $this->driverEntity = $this->getCab5db()
            ->getDriverDao()
            ->updateDriverBlockStatus(
                $this->driverEntity->getId(),
                $this->driverEntity->isBlocked()
            );

        if ($this->driverEntity === null) {
            $this->killAsFailure([
                'failed_to_toggle_driver_block' => true
            ]);
        }

        $this->resSendOK([
            'toggled' => true,
            'new_state' => $this->driverEntity->isBlocked()
        ]);
    }
}