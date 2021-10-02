<?php

class ShowUserAllWallets extends RooiBoosApi {

    const CUSTOMER_EMAIL = "customer_email";

    private ?CustomerEntity $customerEntity;

    protected function onAssemble() {
        if(!isset($_POST[self::CUSTOMER_EMAIL])){
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_EMAIL);
        }

        $this->customerEntity = $this->getRooiBoosDB()->getCustomerDao()->getCustomerWithEmail($_POST[self::CUSTOMER_EMAIL]);

        if($this->customerEntity === null ){
            $this->killAsFailure([
                'customer_not_found' => true
            ]);
        }
    }

    protected function onDevise() {
        $wallets = $this->getRooiBoosDB()->getCustomerWalletDao()->getAllCustomerWallets($this->customerEntity->getId());

        $wallets_data = [];

        /** @var CustomerWalletEntity $wallet */
        foreach ($wallets as $wallet) {
            array_push($wallets_data,
                [
                CustomerWalletTableSchema::ID => $wallet->getId(),
                CustomerWalletTableSchema::CURRENCY_ID => $wallet->getCurrencyId(),
                CustomerWalletTableSchema::BALANCE => $wallet->getBalance(),
                CustomerWalletTableSchema::CREATED_AT => $wallet->getCreatedAt(),
                CustomerWalletTableSchema::UPDATED_AT => $wallet->getUpdatedAt()
                ]
            );
        }

        $this->resSendOK([
            'wallets'=>$wallets_data
        ]);

    }
}