<?php

class TogglePassengerBlock extends Cab5Api {

    private PassengerEntity $passengerEntity;

    protected function onTokenAuthorization() {
        $this->passengerEntity = $this->handlePassengerTokenAuthorization();
    }

    protected function onDevise() {
        $this->passengerEntity->setBlocked(!$this->passengerEntity->isBlocked());

        $this->passengerEntity= $this->getCab5db()
            ->getPassengerDao()
            ->updatePassengerBlockStatus(
                $this->passengerEntity->getId(),
                $this->passengerEntity->isBlocked()
            );

        if ($this->passengerEntity=== null) {
            $this->killAsFailure([
                'failed_to_toggle_driver_block' => true
            ]);
        }

        $this->resSendOK([
            'toggled' => true,
            'new_state' => $this->passengerEntity->isBlocked()
        ]);
    }
}