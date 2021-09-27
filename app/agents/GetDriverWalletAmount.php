<?php

class GetDriverWalletAmount extends Cab5Api {

    private DriverEntity $driverEntity;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onDevise() {
        $this->resSendOK([
            DriverTableSchema::WALLET => $this->driverEntity->getWallet()
        ]);
    }
}