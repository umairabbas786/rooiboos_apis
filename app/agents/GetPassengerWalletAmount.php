<?php

class GetPassengerWalletAmount extends Cab5Api {

    private PassengerEntity $passengerEntity;

    protected function onTokenAuthorization() {
        $this->passengerEntity = $this->handlePassengerTokenAuthorization();
    }

    protected function onDevise() {
        $this->resSendOK([
            PassengerTableSchema::WALLET => $this->passengerEntity->getWallet()
        ]);
    }
}