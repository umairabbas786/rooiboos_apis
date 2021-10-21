<?php

use Carbon\Carbon;

class GetCurrencyFee extends RooiBoosApi {

    private ?CurrencyFeeEntity $currencyFeeEntity;

    protected function onAssemble() {
        $this->currencyFeeEntity = $this->getRooiBoosDB()->getCurrencyFeeDao()->getCurrencyFeeWithId(CurrencyFeeEntity::ID);
    }

    protected function onDevise() {
        $createTime = Carbon::now();


        if ($this->currencyFeeEntity === null) {
            $this->getRooiBoosDB()->getCurrencyFeeDao()->insertCurrencyFee(new CurrencyFeeEntity(
                "0.2", $createTime, $createTime
            ));
        }

        $this->currencyFeeEntity = $this->getRooiBoosDB()->getCurrencyFeeDao()->getCurrencyFeeWithId(CurrencyFeeEntity::ID);

        $this->resSendOK([
            'currency_fee_percent' => (int) $this->currencyFeeEntity->getCurrencyFee()
        ]);
    }
}