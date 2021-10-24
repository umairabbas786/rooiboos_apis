<?php

class GetCurrencyCharges extends RooiBoosApi {

    const FROM = 'from';
    const TO = 'to';

    private ?CurrencyChargesEntity $currencyChargesEntity;

    protected function onAssemble() {
        if(!isset($_POST[self::FROM])){
            $this->killAsBadRequestWithMissingParamException(self::FROM);
        }
        if(!isset($_POST[self::TO])){
            $this->killAsBadRequestWithMissingParamException(self::TO);
        }

        $this->currencyChargesEntity = $this->getRooiBoosDB()->getCurrencyChargesDao()->getCurrencyChargesWithCurrencyIds($_POST[self::FROM],$_POST[self::TO]);
        if($this->currencyChargesEntity === null ){
            $this->killAsFailure([
                'conversion_rate_not_set' => true
            ]);
        }
    }

    protected function onDevise() {
        $currencyCharges = $this->getRooiBoosDB()
            ->getCurrencyChargesDao()
            ->getCurrencyChargesWithCurrencyIds($_POST[self::FROM],$_POST[self::TO]);

        $this->resSendOK([
                'currency_conversion_rate' => (float) $currencyCharges->getRate()
        ]
        );

    }
}