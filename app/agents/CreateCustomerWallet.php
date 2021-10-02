<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class CreateCustomerWallet extends RooiBoosApi {

    const CUSTOMER_EMAIL = 'customer_email';
    const CURRENCY_ID = 'currency_id';

    private ?CustomerEntity $customerEntity;

    protected function onAssemble() {
        if(!isset($_POST[self::CUSTOMER_EMAIL])){
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_EMAIL);
        }
        if(!isset($_POST[self::CURRENCY_ID])){
            $this->killAsBadRequestWithMissingParamException(self::CURRENCY_ID);
        }

        $this->customerEntity = $this->getRooiBoosDB()->getCustomerDao()->getCustomerWithEmail($_POST[self::CUSTOMER_EMAIL]);
        if($this->customerEntity === null ){
            $this->killAsFailure([
                'customer_not_found' => true
            ]);
        }
    }

    protected function onDevise() {
        $wallet = $this->getRooiBoosDB()->getCustomerWalletDao()
            ->getCustomerWalletWithCustomerIdAndCurrencyId(
                $this->customerEntity->getId(),
                $_POST[self::CURRENCY_ID]
            );

        if($wallet !== null){
            $this->killAsFailure([
                'wallet_already_created' => true
            ]);
        }

        $create_time = Carbon::now();

        $wallet = $this->getRooiBoosDB()->getCustomerWalletDao()
            ->createWallet(new CustomerWalletEntity(
                Uuid::uuid4()->toString(),
                $this->customerEntity->getId(),
                $_POST[self::CURRENCY_ID],
                0.0,
                $create_time,
                $create_time
            ));

        if($wallet === null){
            $this->killAsFailure([
                'failed_to_create_wallet' => true
            ]);
        }
        $this->resSendOK([
            'wallet_created' => true,
            'wallet'=> [
                CustomerWalletTableSchema::ID => $wallet->getId(),
                CustomerWalletTableSchema::CURRENCY_ID => $wallet->getCurrencyId(),
                CustomerWalletTableSchema::BALANCE => $wallet->getBalance(),
                CustomerWalletTableSchema::CREATED_AT => $wallet->getCreatedAt(),
                CustomerWalletTableSchema::UPDATED_AT => $wallet->getUpdatedAt()
            ]
        ]);

    }
}