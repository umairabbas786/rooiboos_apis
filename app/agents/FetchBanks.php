<?php

class FetchBanks extends RooiBoosApi {

    protected function onDevise() {
        $data = [];

        /** @var BankEntity $bank */
        foreach ($this->getRooiBoosDB()->getBankDao()->getAllBanks() as $bank){
            array_push($data,[
                BankTableSchema::ID => $bank->getId(),
                BankTableSchema::NAME => $bank->getName(),
                BankTableSchema::CITY => $bank->getCity(),
                BankTableSchema::COUNTRY => $bank->getCountry(),
                BankTableSchema::STATUS => $bank->isStatus(),
                BankTableSchema::CREATED_AT => $bank->getCreatedAt(),
                BankTableSchema::UPDATED_AT => $bank->getUpdatedAt()
            ]);
        }

        $this->resSendOK($data);
    }
}