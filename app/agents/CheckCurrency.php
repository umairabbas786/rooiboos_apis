<?php

class CheckCurrency extends RooiBoosApi {
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

        $currency = $this->getRooiBoosDB()->getCustomerWalletDao()
            ->getCustomerWalletWithCustomerIdAndCurrencyId(
                $this->customerEntity->getId(),
                $_POST[self::CURRENCY_ID]
            );

        $this->resSendOK([
            'currency_check' => $currency === null ? null : true
        ]);
    }
}