<?php

use Carbon\Carbon;

class GetDepositFee extends RooiBoosApi {

    private ?DepositFeeEntity $depositFeeEntity;

    protected function onAssemble() {
        $this->depositFeeEntity = $this->getRooiBoosDB()->getDepositFeeDao()->getDepositFeeWithId(DepositFeeEntity::ID);
    }

    protected function onDevise() {
        $createTime = Carbon::now();


        if ($this->depositFeeEntity === null) {
            $this->getRooiBoosDB()->getDepositFeeDao()->insertDepositFee(new DepositFeeEntity(
                "5", $createTime, $createTime
            ));
        }

        $this->depositFeeEntity = $this->getRooiBoosDB()->getDepositFeeDao()->getDepositFeeWithId(DepositFeeEntity::ID);

        $this->resSendOK([
            'deposit_fee_percent' => (int) $this->depositFeeEntity->getDepositFee()
        ]);
    }
}