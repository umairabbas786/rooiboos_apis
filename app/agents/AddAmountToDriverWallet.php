<?php

class AddAmountToDriverWallet extends Cab5Api {

    private DriverEntity $driverEntity;
    const AMOUNT = "amount";

    protected function onTokenAuthorization() {
        $this->driverEntity= $this->handleDriverTokenAuthorization();
    }

    protected function onDevise() {
        $this->driverEntity->setWallet($this->driverEntity->getWallet() + $_POST[self::AMOUNT]);

        $this->driverEntity= $this->getCab5db()
            ->getDriverDao()
            ->updateDriverWallet(
                $this->driverEntity->getId(),
                $this->driverEntity->getWallet()
            );

        if ($this->driverEntity=== null) {
            $this->killAsFailure([
                'failed_to_update_amount' => true
            ]);
        }

        $this->resSendOK([
            'updated' => true,
            'newAmount' => $this->driverEntity->getWallet()
        ]);
    }
}