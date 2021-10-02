<?php

class FetchCurrency extends RooiBoosApi {

    protected function onDevise() {
        $data = [];

        /** @var CurrencyEntity $currency */
        foreach ($this->getRooiBoosDB()->getCurrencyDao()->getAllCurrency() as $currency){
            array_push($data,[
                CountryTableSchema::ID => $currency->getId(),
                CountryTableSchema::NAME => $currency->getName(),
                CountryTableSchema::CODE => $currency->getCode(),
                CountryTableSchema::CREATED_AT => $currency->getCreatedAt(),
                CountryTableSchema::UPDATED_AT => $currency->getUpdatedAt()
            ]);
        }

        $this->resSendOK($data);
    }
}