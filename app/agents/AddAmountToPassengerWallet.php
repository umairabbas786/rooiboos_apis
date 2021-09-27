<?php

class AddAmountToPassengerWallet extends Cab5Api {

    private PassengerEntity $passengerEntity;
    const AMOUNT = "amount";

    protected function onTokenAuthorization() {
        $this->passengerEntity = $this->handlePassengerTokenAuthorization();
    }

    protected function onDevise() {
        $this->passengerEntity->setWallet($this->passengerEntity->getWallet() + $_POST[self::AMOUNT]);

        $this->passengerEntity = $this->getCab5db()
            ->getPassengerDao()
            ->updatePassengerWallet(
                $this->passengerEntity->getId(),
                $this->passengerEntity->getWallet()
            );

        if ($this->passengerEntity === null) {
            $this->killAsFailure([
                'failed_to_update_amount' => true
            ]);
        }

        $this->resSendOK([
            'updated' => true,
            'newAmount' => $this->passengerEntity->getWallet()
        ]);
    }
}