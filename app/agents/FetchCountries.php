<?php

class FetchCountries extends RooiBoosApi {

    protected function onDevise() {
        $data = [];

        /** @var CountryEntity $country */
        foreach ($this->getRooiBoosDB()->getCountryDao()->getAllCountries() as $country){
            array_push($data,[
                CountryTableSchema::ID => $country->getId(),
                CountryTableSchema::NAME => $country->getName(),
                CountryTableSchema::CODE => $country->getCode(),
                CountryTableSchema::STATUS => $country->isStatus(),
                CountryTableSchema::CREATED_AT => $country->getCreatedAt(),
                CountryTableSchema::UPDATED_AT => $country->getUpdatedAt()
            ]);
        }

        $this->resSendOK($data);
    }
}