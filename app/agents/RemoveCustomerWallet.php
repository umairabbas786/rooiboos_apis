<?php

class RemoveCustomerWallet extends RooiBoosApi {
    private const CUSTOMER_EMAIL = 'customer_email';
    private const CURRENCY_ID = "currency_id";

    private ?CustomerEntity $customerEntity;

    protected function onAssemble() {
        if(!isset($_POST[self::CUSTOMER_EMAIL])){
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_EMAIL);
        }
        if (!isset($_POST[self::CURRENCY_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CURRENCY_ID);
        }
        $this->customerEntity = $this->getRooiBoosDB()->getCustomerDao()->getCustomerWithEmail($_POST[self::CUSTOMER_EMAIL]);

    }

    protected function onDevise() {

        $remove_currency = $this->getRooiBoosDB()->getCustomerWalletDao()
            ->removeCustomerWallet(
                $this->customerEntity->getId(),
                $_POST[self::CURRENCY_ID]
            );

        $this->resSendOK([
            'remove_currency' => $remove_currency === null ? null : true
        ]);
    }
}